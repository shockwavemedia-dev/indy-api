<?php

declare(strict_types=1);

namespace App\Jobs\Tickets;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\User;
use App\Services\Slack\Exceptions\SlackSendMessageException;
use App\Services\Slack\Exceptions\SlackUserNullException;
use App\Services\Slack\Interfaces\SlackSendMessageInterface;
use App\Services\Slack\Interfaces\SlackUserResolverInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class TicketFileSlackNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private User $user,
        private string $message,
        private string $ticketId
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(
        SlackUserResolverInterface $slackUserResolver,
        SlackSendMessageInterface $slackSendMessage,
        ErrorLogInterface $sentryHandler
    ): void {
        try {
            $url = Config::get('mail.client_url', null);

            if ($url === null) {
                throw new \Exception('Url for client is empty');
            }

            $url = sprintf('%s/ticket/%s', $url, $this->ticketId);

            $slackUser = $slackUserResolver->findSlackUser($this->user);

            $slackSendMessage->sendMessage($slackUser, \sprintf('%s %s', $this->message, $url));

            $sentryHandler->log($this->message);
        } catch (SlackUserNullException|SlackSendMessageException $exception) {
            $sentryHandler->log(sprintf('This email does not have slack account %s', $this->user->getEmail()));
        } catch (UnknownProperties $e) {
            $sentryHandler->reportError($e);
        }
    }
}
