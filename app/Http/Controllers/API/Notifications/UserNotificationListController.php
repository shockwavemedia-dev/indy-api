<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Notifications\NotificationsResource;
use App\Models\User;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserNotificationListController extends AbstractAPIController
{
    private NotificationRepositoryInterface $notificationRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function __invoke(): JsonResource
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user === null) {
            return $this->respondNotFound(['message'=> 'User not found']);
        }

        $notifications = $this->notificationRepository->findAllNewNotificationByUser($user);

        return new NotificationsResource($notifications, $user);
    }
}
