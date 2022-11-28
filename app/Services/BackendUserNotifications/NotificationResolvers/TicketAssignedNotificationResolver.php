<?php

declare(strict_types=1);

namespace App\Services\BackendUserNotifications\NotificationResolvers;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Enum\NotificationStatusEnum;
use App\Models\Tickets\TicketAssignee;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class TicketAssignedNotificationResolver extends AbstractBackendUserNotificationResolver implements BackendUserNotificationResolverInterface
{
    /**
     * @var string
     */
    private const TITLE_KEY = '%s has assigned a ticket # %s to you';

    /**
     * @param  TicketAssignee  $morph
     *
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
                $morph->getCreatedBy()->getUser()->getFirstName(),
                $morph->getTicket()->getTicketCode(),
            ),
        ]);

        $this->saveNotification($notificationResource, $morph->getAdminUser()->getUser());
    }

    public function supports(BackendUserNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === BackendUserNotificationTypeEnum::ASSIGNED_TICKET;
    }
}
