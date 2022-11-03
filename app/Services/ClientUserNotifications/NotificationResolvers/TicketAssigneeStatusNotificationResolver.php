<?php

declare(strict_types=1);

namespace App\Services\ClientUserNotifications\NotificationResolvers;

use App\Enum\ClientNotificationTypeEnum;
use App\Enum\NotificationStatusEnum;
use App\Models\Tickets\TicketAssignee;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class TicketAssigneeStatusNotificationResolver extends AbstractClientNotificationResolver implements ClientNotificationResolverInterface
{
    /**
     * @var string
     */
    private const TITLE_KEY = '%s has changed the staff status in ticket # %s';

    /**
     * @param TicketAssignee $morph
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
                $morph->getUpdatedBy()->getUser()->getFirstName(),
                $morph->getTicket()->getTicketCode(),
            ),
        ]);

        $this->saveNotification($notificationResource, $morph->getTicket()->getCreatedBy());
    }

    public function supports(ClientNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === ClientNotificationTypeEnum::TICKET_ASSIGNEE_STATUS;
    }
}
