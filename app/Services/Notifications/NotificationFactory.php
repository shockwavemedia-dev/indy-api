<?php

declare(strict_types=1);

namespace App\Services\Notifications;

use App\Models\Notification;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Services\Notifications\Interfaces\NotificationFactoryInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;

final class NotificationFactory implements NotificationFactoryInterface
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository) {
        $this->notificationRepository = $notificationRepository;
    }

    public function make(CreateNotificationResource $resource): Notification
    {
        $exist = $this->notificationRepository->findByMorph(
            $resource->getMorphable(),
            $resource->getTitle()
        );

        if ($exist !== null) {
            return $exist;
        }

        /** @var Notification $notification */
        $notification = $this->notificationRepository->create([
            'description' => $resource->getDescription(),
            'link' => $resource->getLink(),
            'morphable_id' => $resource->getMorphable()->getId(),
            'morphable_type' => \get_class($resource->getMorphable()),
            'status' => $resource->getStatusEnum()->getValue(),
            'title' => $resource->getTitle(),
        ]);

        return $notification;
    }
}
