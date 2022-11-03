<?php

declare(strict_types=1);

namespace App\Services\Tickets\Resolvers;

use App\Enum\EmailStatusEnum;
use App\Enum\NotificationStatusEnum;
use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use App\Services\Notifications\Interfaces\NotificationFactoryInterface;
use App\Services\Notifications\Interfaces\NotificationUserFactoryInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;
use App\Services\Notifications\Resources\CreateNotificationUserResource;
use App\Services\Slack\Interfaces\SlackSendMessageInterface;
use App\Services\Slack\Interfaces\SlackUserResolverInterface;
use Exception;
use Illuminate\Support\Facades\Config;
use Throwable;

abstract class AbstractTicketNotificationResolver
{
    private EmailLogFactoryInterface $emailLogFactory;

    private ErrorLogInterface $errorLogger;

    private NotificationFactoryInterface $notificationFactory;

    private NotificationUserFactoryInterface $notificationUserFactory;

    private SlackUserResolverInterface $slackUserResolver;

    private SlackSendMessageInterface $slackSendMessage;

    public function __construct(
        EmailLogFactoryInterface $emailLogFactory,
        ErrorLogInterface $errorLogger,
        NotificationFactoryInterface $notificationFactory,
        NotificationUserFactoryInterface $notificationUserFactory,
        SlackUserResolverInterface $slackUserResolver,
        SlackSendMessageInterface $slackSendMessage
    ) {
        $this->emailLogFactory = $emailLogFactory;
        $this->errorLogger = $errorLogger;
        $this->notificationFactory = $notificationFactory;
        $this->notificationUserFactory = $notificationUserFactory;
        $this->slackUserResolver = $slackUserResolver;
        $this->slackSendMessage = $slackSendMessage;
    }

    /**
     * @throws Exception
     */
    public function sendNotification(Ticket $ticket, User $user): void
    {
        $url = Config::get('mail.client_url', null);

        if ($url === null) {
            throw new Exception('Url for client is empty');
        }

        $url = sprintf('%s/ticket/%s', $url, $ticket->getId());

        $this->sendEmailNotification($ticket, $user, $url);

        try {
            $this->sendSlackNotification($ticket, $user, $url);

        } catch (\Throwable $throwable) {
            $this->errorLogger->reportError($throwable);
        } finally {
            $this->saveNotification($ticket, $user);
        }
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function sendEmailNotification(Ticket $ticket, User $user, string $url): void
    {
        $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
            'message' => $this->getMessage($ticket, $user, $url),
            'to' => $user->getEmail(),
            'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
            'emailType' => $ticket,
        ]));

        try {
            $user->sendEmailToAccountManager($ticket, $emailLog);
        } catch (Throwable $exception) {
            $emailLog->setStatus(new EmailStatusEnum(EmailStatusEnum::FAILED));
            $emailLog->save();
            $this->errorLogger->reportError($exception);
        }
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\Slack\Exceptions\SlackUserNullException
     * @throws \App\Services\Slack\Exceptions\SlackSendMessageException
     */
    private function sendSlackNotification(Ticket $ticket, User $user, string $url): void
    {
        $slackUser = $this->slackUserResolver->findSlackUser($user);

        $this->slackSendMessage->sendMessage($slackUser, $this->getMessage($ticket, $user, $url));
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function saveNotification(Ticket $ticket, User $user):  void
    {
        $notification = $this->notificationFactory->make(new CreateNotificationResource([
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => $this->getNotificationTitle($ticket),
            'link' => \sprintf('ticket/%s', $ticket->getId()),
            'morphable' => $ticket,
        ]));

        $this->notificationUserFactory->make(new CreateNotificationUserResource([
            'notification' => $notification,
            'user' => $user,
        ]));
    }

    abstract protected function getMessage(Ticket $ticket, User $user, string $url): string;

    abstract protected function getNotificationTitle(Ticket $ticket): string;
}
