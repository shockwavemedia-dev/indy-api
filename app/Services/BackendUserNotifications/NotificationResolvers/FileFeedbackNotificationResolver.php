<?php

declare(strict_types=1);

namespace App\Services\BackendUserNotifications\NotificationResolvers;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Enum\NotificationStatusEnum;
use App\Models\Tickets\FileFeedback;
use App\Models\Tickets\TicketAssignee;
use App\Models\User;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class FileFeedbackNotificationResolver extends AbstractBackendUserNotificationResolver implements BackendUserNotificationResolverInterface
{
    /**
     * @var string
     */
    private const TITLE_KEY = '%s has messaged you regarding ticket # %s';

    /**
     * @param FileFeedback $morph
     * @return void
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(mixed $morph): void
    {
        $ticketAssignees = $morph->getClientTicketFile()->getTicket()->getTicketAssignees();

        /** @var TicketAssignee $ticketAssignee */
        foreach ($ticketAssignees as $ticketAssignee) {
            $this->resolveNotification($morph, $ticketAssignee->getAdminUser()->getUser());
        }
    }

    /**
     * @param FileFeedback $morph
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function resolveNotification(mixed $morph, User $user): void
    {
        if ($morph->getFeedbackBy()->getId() === $user->getId()) {
            return;
        }

        $notificationResource = new CreateNotificationResource([
            'morphable' => $morph,
            'link' => \sprintf('ticket/file/%s', $morph->getClientFileId()),
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => sprintf(
                self::TITLE_KEY,
                $morph->getFeedbackBy()->getFirstName(),
                $morph->getClientTicketFile()->getTicket()->getTicketCode(),
            ),
        ]);

        $this->saveNotification($notificationResource, $user);
    }

    public function supports(BackendUserNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === BackendUserNotificationTypeEnum::FILE_FEEDBACK;
    }
}
