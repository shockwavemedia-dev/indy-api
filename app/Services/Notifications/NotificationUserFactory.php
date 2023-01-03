<?php

declare(strict_types=1);

namespace App\Services\Notifications;

use App\Models\NotificationUser;
use App\Repositories\Interfaces\NotificationUserRepositoryInterface;
use App\Services\Notifications\Interfaces\NotificationUserFactoryInterface;
use App\Services\Notifications\Resources\CreateNotificationUserResource;

final class NotificationUserFactory implements NotificationUserFactoryInterface
{
    private NotificationUserRepositoryInterface $notificationUserRepository;

    public function __construct(NotificationUserRepositoryInterface $notificationUserRepository)
    {
        $this->notificationUserRepository = $notificationUserRepository;
    }

    public function make(CreateNotificationUserResource $resource): NotificationUser
    {
        /** @var NotificationUser $notificationUser */
        $notificationUser = $this->notificationUserRepository->create([
            'user_id' => $resource->getUser()->getId(),
            'notification_id' => $resource->getNotification()->getId(),
        ]);

        return $notificationUser;
    }
}
