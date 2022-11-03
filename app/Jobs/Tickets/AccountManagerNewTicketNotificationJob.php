<?php

declare(strict_types=1);

namespace App\Jobs\Tickets;

use App\Enum\EmailStatusEnum;
use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
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
use function sprintf;
use Throwable;

final class AccountManagerNewTicketNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $ticketId;

    private int $userId;

    public function __construct(int $ticketId, int $userId)
    {
        $this->ticketId = $ticketId;
        $this->userId = $userId;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws Exception
     */
    public function handle(
        EmailLogFactoryInterface $emailLogFactory,
        ErrorLogInterface $sentryHandler,
        SlackUserResolverInterface $slackUserResolver,
        SlackSendMessageInterface $slackSendMessage,
        TicketRepositoryInterface $ticketRepository,
        UserRepositoryInterface $userRepository
    ): void {

        $ticket = $ticketRepository->find($this->ticketId);

        $user = $userRepository->find($this->userId);

        $url = Config::get('mail.client_url', null);

        if ($url === null) {
            throw new Exception('Url for client is empty');
        }

        $url = sprintf('%s/ticket/%s', $url, $ticket->getId());

        $message = sprintf(
            'Hi %s, %s Ticket %s has been created. You may check the link here %s',
            $user->getFirstName(),
            \ucfirst($ticket->getType()->getValue()),
            $ticket->getTicketCode(),
            $url
        );

        try {
            $slackUser = $slackUserResolver->findSlackUser($user);

            $slackSendMessage->sendMessage($slackUser, $message);
        } catch (SlackUserNullException $nullException) {
            $sentryHandler->log(
                sprintf(
                    'This email does not have slack account %s',
                    $user->getEmail()
                )
            );
        } catch (Throwable $exception) {
            $sentryHandler->reportError($exception);
        }

        $emailLog = $emailLogFactory->make(new CreateEmailLogResource([
            'message' => $message,
            'to' => $user->getEmail(),
            'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
            'emailType' => $ticket,
        ]));

        try {
            $user->sendEmailToAccountManager($ticket, $emailLog);

            $sentryHandler->log($message);
        } catch (Throwable $exception) {
            $emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::FAILED));
            $emailLog->save();
            $sentryHandler->reportError($exception);
        }
    }
}
