<?php

declare(strict_types=1);

namespace App\Services\BackendUserNotifications\NotificationResolvers;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Enum\NotificationStatusEnum;
use App\Models\Tickets\TicketAssignee;
use App\Models\Tickets\TicketNote;
use App\Models\User;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class TicketNoteNotificationResolver extends AbstractBackendUserNotificationResolver implements BackendUserNotificationResolverInterface
{
    /**
     * @var string
     */
    private const TITLE_KEY = '%s has posted a note in ticket # %s';

    /**
     * @param TicketNote $morph
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(mixed $morph): void
    {
        $ticketAssignees = $morph->getTicket()->getTicketAssignees();

        /** @var TicketAssignee $ticketAssignee */
        foreach ($ticketAssignees as $ticketAssignee) {
            $this->resolveNotification($morph, $ticketAssignee->getAdminUser()->getUser());
        }
    }

    /**
     * @param TicketNote $morph
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function resolveNotification(mixed $morph, User $user): void
    {
        if ($morph->getCreatedBy()->getId() === $user->getId()) {
            return;
        }

        $notificationResource = new CreateNotificationResource([
            'morphable' => $morph,
            'link' => \sprintf('ticket/%s', $morph->getTicketId()),
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => sprintf(
                self::TITLE_KEY,
                $morph->getCreatedBy()->getFirstName(),
                $morph->getTicket()->getTicketCode(),
            ),
        ]);

        $this->saveNotification($notificationResource, $user);
    }

    public function supports(BackendUserNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === BackendUserNotificationTypeEnum::TICKET_NOTES;
    }
}
