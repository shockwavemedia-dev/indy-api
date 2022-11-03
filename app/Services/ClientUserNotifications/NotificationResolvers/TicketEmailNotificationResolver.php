<?php

declare(strict_types=1);

namespace App\Services\ClientUserNotifications\NotificationResolvers;

use App\Enum\ClientNotificationTypeEnum;
use App\Enum\NotificationStatusEnum;
use App\Models\Tickets\TicketEmail;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class TicketEmailNotificationResolver extends AbstractClientNotificationResolver implements ClientNotificationResolverInterface
{
    /**
     * @var string
     */
    private const TITLE_KEY = '%s has posted an email in ticket # %s';

    /**
     * @param TicketEmail $morph
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(mixed $morph): void
    {
        if ($morph->getSenderBy()->getId() === $morph->getTicket()->getCreatedBy()->getId()) {
            return;
        }

        $notificationResource = new CreateNotificationResource([
            'morphable' => $morph,
            'link' => \sprintf('ticket/%s', $morph->getTicketId()),
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => sprintf(
                self::TITLE_KEY,
                $morph->getSenderBy()->getFirstName(),
                $morph->getTicket()->getTicketCode(),
            ),
        ]);

        $this->saveNotification($notificationResource, $morph->getTicket()->getCreatedBy());
    }

    public function supports(ClientNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === ClientNotificationTypeEnum::TICKET_EMAILS;
    }
}
