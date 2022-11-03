<?php

declare(strict_types=1);

namespace App\Jobs\Tickets;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\Client;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\Slack\Exceptions\SlackSendMessageException;
use App\Services\Slack\Exceptions\SlackUserNullException;
use App\Services\Slack\Interfaces\SlackSendMessageInterface;
use App\Services\Slack\Interfaces\SlackUserResolverInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class NewGraphicRequestNotifyAdminSlackNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Client $client;

    private Ticket $ticket;

    private User $user;

    public function __construct(Client $client,User $user, Ticket $ticket)
    {
        $this->client = $client->withoutRelations();
        $this->ticket = $ticket->withoutRelations();
        $this->user = $user->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws UnknownProperties
     * @throws Exception
     */
    public function handle(
        SlackUserResolverInterface $slackUserResolver,
        SlackSendMessageInterface $slackSendMessage,
        ErrorLogInterface $sentryHandler
    ): void {
        try {
            $slackUser = $slackUserResolver->findSlackUser($this->user);

            $url = Config::get('mail.client_url', null);

            if ($url === null) {
                throw new \Exception('Url for client is empty');
            }

            $url = sprintf('%s/ticket/%s', $url, $this->ticket->getId());

            $message = sprintf(
                'Graphic Request has been created for client %s. You may check the link here %s.',
                $this->client->getName(),
                $url
            );

            $slackSendMessage->sendMessage($slackUser, $message);

            $sentryHandler->log($message);
        } catch (SlackUserNullException | SlackSendMessageException $exception) {
            $sentryHandler->reportError($exception);
            $sentryHandler->log(\sprintf('This email does not have slack account %s',$this->user->getEmail()));
        }
    }
}
