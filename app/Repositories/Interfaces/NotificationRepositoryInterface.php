<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface NotificationRepositoryInterface
{
    public function findByMorph(mixed $morph, string $title): ?Notification;

    public function findAllNewNotificationByUser(User $user): Collection;
}
