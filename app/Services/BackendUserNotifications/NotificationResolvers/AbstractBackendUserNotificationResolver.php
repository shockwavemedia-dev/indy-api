<?php

declare(strict_types=1);

namespace App\Services\BackendUserNotifications\NotificationResolvers;

use App\Models\User;
use App\Services\Notifications\Interfaces\NotificationFactoryInterface;
use App\Services\Notifications\Interfaces\NotificationUserFactoryInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;
use App\Services\Notifications\Resources\CreateNotificationUserResource;

abstract class AbstractBackendUserNotificationResolver
{
    public function __construct(
        protected NotificationFactoryInterface $notificationFactory,
        protected NotificationUserFactoryInterface $notificationUserFactory
    ) {
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function saveNotification(
        CreateNotificationResource $notificationResource,
        User $user
    ): void {
        $notification = $this->notificationFactory->make($notificationResource);

        $this->notificationUserFactory->make(new CreateNotificationUserResource([
            'notification' => $notification,
            'user' => $user,
        ]));
    }
}
