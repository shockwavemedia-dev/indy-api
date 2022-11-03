<?php

declare(strict_types=1);

namespace App\Services\Notifications\Interfaces;

use App\Models\Notification;
use App\Services\Notifications\Resources\CreateNotificationResource;

interface NotificationFactoryInterface
{
    public function make(CreateNotificationResource $resource): Notification;
}
