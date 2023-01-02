<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Notifications;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\User;
use App\Repositories\Interfaces\NotificationUserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class NotificationMarkAllAsReadController extends AbstractAPIController
{
    private NotificationUserRepositoryInterface $notificationUserRepository;

    public function __construct(
        NotificationUserRepositoryInterface $notificationUserRepository
    ) {
        $this->notificationUserRepository = $notificationUserRepository;
    }

    public function __invoke(): JsonResource
    {
        /** @var User $user */
        $user = $this->getUser();

        $this->notificationUserRepository->markAllAsReadByUser($user);

        return $this->respondNoContent();
    }
}
