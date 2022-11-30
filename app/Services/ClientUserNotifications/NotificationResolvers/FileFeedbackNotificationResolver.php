<?php

declare(strict_types=1);

namespace App\Services\ClientUserNotifications\NotificationResolvers;

use App\Enum\ClientNotificationTypeEnum;
use App\Enum\NotificationStatusEnum;
use App\Models\Tickets\FileFeedback;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class FileFeedbackNotificationResolver extends AbstractClientNotificationResolver implements ClientNotificationResolverInterface
{
    /**
     * @var string
     */
    private const TITLE_KEY = '%s has messaged you regarding ticket # %s';

    /**
     * @param  FileFeedback  $morph
     * @return void
     *
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(mixed $morph): void
    {
        if ($morph->getClientTicketFile()
                ->getTicket()
                ->getCreatedBy()
                ->getId() === $morph->getFeedbackBy()->getId()
        ) {
            return;
        }

        $notificationResource = new CreateNotificationResource([
            'morphable' => $morph,
            'link' => \sprintf('ticket/file/%s', $morph->getClientFileId()),
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => sprintf(
                self::TITLE_KEY,
                $morph->getFeedbackBy()
                    ->getFirstName(),
                $morph->getClientTicketFile()
                    ->getTicket()
                    ->getTicketCode(),
            ),
        ]);

        $this->saveNotification(
            $notificationResource,
            $morph->getClientTicketFile()
                ->getTicket()
                ->getCreatedBy()
        );
    }

    public function supports(ClientNotificationTypeEnum $typeEnum): bool
    {
        return $typeEnum->getValue() === ClientNotificationTypeEnum::FILE_FEEDBACK;
    }
}
