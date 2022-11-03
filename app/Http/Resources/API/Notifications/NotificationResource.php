<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Notifications;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;

final class NotificationResource extends Resource
{
    private User $user;

    public function __construct($resource, User $user)
    {
        $this->user = $user;

        parent::__construct($resource);
    }

    /**
     * @return mixed[]
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Notification) === false) {
            throw new InvalidResourceTypeException(
                Notification::class
            );
        }

        $notificationUsers = $this->resource->getNotificationUsers();

        /** @var NotificationUser $notificationUser */
        $notificationUser = $notificationUsers->firstWhere('user_id', $this->user->getId());

        return [
            'id' => $this->resource->getId(),
            'title' => $this->resource->getTitle(),
            'status' => $notificationUser->getStatus()->getValue(),
            'url' => $this->resource->getLink(),
            'morphable_id' => $this->resource->getAttribute('morphable_id'),
            'morphable_type' => $this->resource->getAttribute('morphable_type'),
            'created_at' => $this->resource->getCreatedAt(),
        ];
    }
}
