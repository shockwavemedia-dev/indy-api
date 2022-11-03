<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Enum\NotificationUserStatusEnum;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;

interface NotificationUserRepositoryInterface
{
    public function countNewNotificationByUser(User $user): int;

    public function markAllAsReadByUser(User $user): void;

    public function findByNotificationAndUser(Notification $notification, User $user): ?NotificationUser;

    public function updateAllNotificationsUserStatus(
        NotificationUserStatusEnum $statusEnum,
        User $user): void;

    public function updateNotificationUserStatus(
        NotificationUser $notificationUser,
        NotificationUserStatusEnum $statusEnum
    ): NotificationUser;
}

