<?php

declare(strict_types=1);

namespace App\Services\Notifications;

use App\Enum\EmailStatusEnum;
use App\Jobs\SendSlackNotificationJob;
use App\Models\User;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use App\Services\Notifications\Interfaces\GenericNotificationSenderResolverInterface;
use Exception;
use Illuminate\Support\Facades\Config;

final class GenericNotificationSenderResolver implements GenericNotificationSenderResolverInterface
{
    public function __construct(
        private EmailLogFactoryInterface $emailLogFactory
    ) {
    }

    /**
     * @throws Exception
     */
    public function resolve(
        User $user,
        mixed $object,
        string $message,
        string $link,
        string $subject
    ): void {
        $url = Config::get('mail.client_url', null);

        if ($url === null) {
            throw new Exception('Url for client is empty');
        }

        $url = sprintf('%s%s', $url, $link);

        $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
            'emailType' => $object,
            'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
            'to' => $user->getEmail(),
            'message' => $message,
        ]));

        $user->sendGenericNotification($emailLog, $message, $url, $subject);

        $slackMessageWithLink = sprintf(
            '%s You may check the link here %s',
            $message,
            $url,
        );

        SendSlackNotificationJob::dispatch($user->getId(), $slackMessageWithLink);
    }
}
