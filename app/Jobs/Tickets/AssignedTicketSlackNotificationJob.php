<?php

declare(strict_types=1);

namespace App\Jobs\Tickets;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\Slack\Exceptions\SlackSendMessageException;
use App\Services\Slack\Exceptions\SlackUserNullException;
use App\Services\Slack\Interfaces\SlackSendMessageInterface;
use App\Services\Slack\Interfaces\SlackUserResolverInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class AssignedTicketSlackNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Ticket $ticket;

    private User $user;

    private User $createdBy;

    public function __construct(User $createdBy, User $user, Ticket $ticket)
    {
        $this->createdBy = $createdBy->withoutRelations();
        $this->ticket = $ticket->withoutRelations();
        $this->user = $user->withoutRelations();
    }

    /**
     * @throws UnknownProperties
     * @throws Exception
     */
    public function handle(
        SlackUserResolverInterface $slackUserResolver,
        SlackSendMessageInterface $slackSendMessage,
        ErrorLogInterface $sentryHandler
    ): void {
        $url = Config::get('mail.client_url', null);

        if ($url === null) {
            throw new \Exception('Url for client is empty');
        }

        $url = sprintf('%s/ticket/%s', $url, $this->ticket->getId());

        $username = $this->user->getFirstName();

        if ($this->createdBy->getEmail() === 'superadmin@indy.com.au') {
            $username = 'The Indy Platform';
        }

        $message = \sprintf(
            'Hi %s, %s has assigned Ticket #%s to you. You may check the link here %s',
            $this->user->getFirstName(),
            $username,
            $this->ticket->getTicketCode(),
            $url
        );

        try {
            $slackUser = $slackUserResolver->findSlackUser($this->user);

            $slackSendMessage->sendMessage($slackUser, $message);

            $sentryHandler->log($message);
        } catch (SlackUserNullException | SlackSendMessageException $exception) {
            $sentryHandler->reportError($exception);
            $sentryHandler->log(\sprintf('This email does not have slack account %s', $this->user->getEmail()));
        }
    }
}
