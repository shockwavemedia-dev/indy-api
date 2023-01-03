<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Notifications;

use App\Enum\NotificationUserStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\Interfaces\NotificationUserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class NotificationDeleteController extends AbstractAPIController
{
    private NotificationRepositoryInterface $notificationRepository;

    private NotificationUserRepositoryInterface $notificationUserRepository;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationUserRepositoryInterface $notificationUserRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationUserRepository = $notificationUserRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var Notification $notification */
        $notification = $this->notificationRepository->find($id);

        /** @var User $user */
        $user = $this->getUser();

        if ($notification === null) {
            return $this->respondNoContent();
        }

        $notificationUser = $this->notificationUserRepository->findByNotificationAndUser(
            $notification,
            $user
        );

        if ($notificationUser === null) {
            return $this->respondNoContent();
        }

        $this->notificationUserRepository->updateNotificationUserStatus(
            $notificationUser,
            new NotificationUserStatusEnum(NotificationUserStatusEnum::DELETED)
        );

        return $this->respondNoContent();
    }
}
