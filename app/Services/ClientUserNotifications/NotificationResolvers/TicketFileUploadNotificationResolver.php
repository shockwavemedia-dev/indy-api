<?php

declare(strict_types=1);

namespace App\Services\ClientUserNotifications\NotificationResolvers;

use App\Enum\ClientNotificationTypeEnum;
use App\Enum\NotificationStatusEnum;
use App\Models\Tickets\ClientTicketFile;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class TicketFileUploadNotificationResolver extends AbstractClientNotificationResolver implements ClientNotificationResolverInterface
{
    /**
     * @var string
     */
    private const TITLE_KEY = '%s is requesting approval for a design in ticket # %s';

    /**
     * @param ClientTicketFile $morph
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(mixed $morph): void
    {
        $notificationResource = new CreateNotificationResource([
            'morphable' => $morph,
            'link' => \sprintf('ticket/%s', $morph->getTicketId()),
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => sprintf(
                self::TITLE_KEY,
                $morph->getAdminUser()->getUser()->getFirstName(),
                $morph->getTicket()->getTicketCode(),
            ),
        ]);

        $this->saveNotification($notificationResource, $morph->getTicket()->getCreatedBy());
    }

    public function supports(ClientNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === ClientNotificationTypeEnum::TICKET_FILE_UPLOADED;
    }
}
