<?php

declare(strict_types=1);

namespace App\Services\ClientUserNotifications\NotificationResolvers;

use App\Models\User;
use App\Services\Notifications\Interfaces\NotificationFactoryInterface;
use App\Services\Notifications\Interfaces\NotificationUserFactoryInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;
use App\Services\Notifications\Resources\CreateNotificationUserResource;

abstract class AbstractClientNotificationResolver
{
    private NotificationFactoryInterface $notificationFactory;

    private NotificationUserFactoryInterface $notificationUserFactory;

    public function __construct(
        NotificationFactoryInterface $notificationFactory,
        NotificationUserFactoryInterface $notificationUserFactory
    ) {
        $this->notificationFactory = $notificationFactory;
        $this->notificationUserFactory = $notificationUserFactory;
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
            'user' => $user
        ]));
    }
}
