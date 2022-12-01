<?php

declare(strict_types=1);

namespace App\Services\ClientUserNotifications\NotificationResolvers;

use App\Enum\ClientNotificationTypeEnum;
use App\Enum\EmailStatusEnum;
use App\Enum\NotificationStatusEnum;
use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class TicketFileUploadNotificationResolver extends AbstractClientNotificationResolver implements ClientNotificationResolverInterface
{
    /**
     * @var string
     */
    private const TITLE_KEY = '%s is requesting approval for a design in ticket # %s';

    /**
     * @param  ClientTicketFile  $morph
     *
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(mixed $morph): void
    {
        $clientCreator = $morph->getTicket()->getCreatedBy();

        $title = sprintf(
            self::TITLE_KEY,
            $morph->getAdminUser()->getUser()->getFirstName(),
            $morph->getTicket()->getTicketCode(),
        );

        $link = \sprintf('ticket/%s', $morph->getTicketId());

        $notificationResource = new CreateNotificationResource([
            'morphable' => $morph,
            'link' => $link,
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => $title,
        ]);

        $this->saveNotification($notificationResource, $clientCreator);

        $this->sendEmailNotification($morph, $clientCreator, $title, $link);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function sendEmailNotification(
        ClientTicketFile $clientTicketFile,
        User $clientUser,
        string $title,
        string $link
    ): void {
        $clientUser->notifyClientForFileUpload(
            $this->emailLogFactory->make(new CreateEmailLogResource([
                'emailType' => $clientTicketFile,
                'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
                'to' => $clientUser->getEmail(),
                'message' => $title, // Static message, real email is in json format
            ])),
            $title,
            $link
        );
    }

    public function supports(ClientNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === ClientNotificationTypeEnum::TICKET_FILE_UPLOADED;
    }
}
