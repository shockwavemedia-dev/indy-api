<?php

declare(strict_types=1);

namespace App\Jobs\TicketChats;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
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

final class TicketChatNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $createdById,
        private int $userId,
        private int $ticketId
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(
        UserRepositoryInterface $userRepository,
        TicketRepositoryInterface $ticketRepository,
        SlackUserResolverInterface $slackUserResolver,
        SlackSendMessageInterface $slackSendMessage,
        ErrorLogInterface $sentryHandler
    ): void {
        $user = $userRepository->find($this->userId);

        try {
            $slackUser = $slackUserResolver->findSlackUser($user);

            $createdBy = $userRepository->find($this->createdById);

            /** @var Ticket $ticket */
            $ticket = $ticketRepository->find($this->ticketId);

            $url = Config::get('mail.client_url', null);

            if ($url === null) {
                throw new Exception('Url for client is empty');
            }

            $url = sprintf('%s/ticket/%s', $url, $ticket->getId());

            $message = \sprintf(
                'Hi %s, You have been mentioned by %s in ticket %s. You may check the link here %s',
                $user->getFirstName(),
                $createdBy->getFirstName(),
                $ticket->getId(),
                $url
            );

            $slackSendMessage->sendMessage(
                $slackUser,
                $message,
            );

            $sentryHandler->log($message);
        } catch (SlackUserNullException | SlackSendMessageException $exception) {
            $sentryHandler->log(
                sprintf(
                    'This email does not have slack account %s',
                    $user->getEmail()
                )
            );
        } catch (UnknownProperties $e) {
            $sentryHandler->reportError($e);
        }
    }
}
