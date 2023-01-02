<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Notifications;

use App\Http\Resources\Resource;
use App\Models\User;

final class NotificationsResource extends Resource
{
    private User $user;

    public function __construct($resource, User $user)
    {
        $this->user = $user;

        parent::__construct($resource);
    }

    protected function getResponse(): array
    {
        $notifications = [];

        foreach ($this->resource as $notification) {
            $notifications['data'][] = new NotificationResource($notification, $this->user);
        }

        return $notifications;
    }
}
