<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\NotificationUserStatusEnum;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Notification());
    }

    /**
     * @param  mixed  $morph
     * @return Notification
     */
    public function findByMorph(mixed $morph, string $title): ?Notification
    {
        return $this->model
            ->where('morphable_type', '=', \get_class($morph))
            ->where('morphable_id', '=', $morph->getId())
            ->where('title', '=', $title)
            ->first();
    }

    public function findAllNewNotificationByUser(User $user): Collection
    {
        return $this->model->whereHas('notificationUsers', function ($query) use ($user) {
            $query->where('user_id', '=', $user->getId());
            $query->where('status', '<>', NotificationUserStatusEnum::DELETED);
        })
            ->orderBy('id', 'desc')
            ->get();
    }
}
