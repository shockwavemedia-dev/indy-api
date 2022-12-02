<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\NotificationUserStatusEnum;
use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Repositories\Interfaces\NotificationUserRepositoryInterface;

final class NotificationUserRepository extends BaseRepository implements NotificationUserRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new NotificationUser());
    }

    public function countNewNotificationByUser(User $user): int
    {
        return $this->model->where('user_id', '=', $user->getId())
            ->where('status', '=', NotificationUserStatusEnum::NEW)
            ->count();
    }

    public function markAllAsReadByUser(User $user): void
    {
        $this->model->where('user_id', '=', $user->getId())
            ->where('status', '=', NotificationUserStatusEnum::NEW)
            ->update([
                'status' => NotificationUserStatusEnum::READ,
            ]);
    }

    public function findByNotificationAndUser(Notification $notification, User $user): ?NotificationUser
    {
        return $this->model->where('user_id', '=', $user->getId())
            ->where('notification_id', '=', $notification->getId())
            ->first();
    }

    public function updateAllNotificationsUserStatus(
        NotificationUserStatusEnum $statusEnum,
        User $user
    ): void {
        $this->model->where('user_id', '=', $user->getId())
            ->update([
                'status' => $statusEnum->getValue(),
            ]);
    }

    public function updateNotificationUserStatus(
        NotificationUser $notificationUser,
        NotificationUserStatusEnum $statusEnum
    ): NotificationUser {
        $notificationUser->setAttribute('status', $statusEnum->getValue());
        $notificationUser->save();

        return $notificationUser;
    }

    public function markNotificationAsReadByTicketFile(ClientTicketFile $clientTicketFile): void
    {
        $this->model->whereHas('notification', function($query) use($clientTicketFile) {
            $query->where('morphable_type', 'App\Models\Tickets\ClientTicketFile');
            $query->where('morphable_id', $clientTicketFile->getId());
            $query->where('link', \sprintf('ticket/%s', $clientTicketFile->getTicketId()));
        })->update([
            'status' => NotificationUserStatusEnum::READ,
        ]);
    }
}
