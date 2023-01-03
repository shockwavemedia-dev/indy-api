<?php

declare(strict_types=1);

namespace App\Services\Notifications\Interfaces;

use App\Models\NotificationUser;
use App\Services\Notifications\Resources\CreateNotificationUserResource;

interface NotificationUserFactoryInterface
{
    public function make(CreateNotificationUserResource $resource): NotificationUser;
}
