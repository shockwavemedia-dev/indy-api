<?php

declare(strict_types=1);

namespace App\Jobs\NotificationsList;

use App\Enum\NotificationStatusEnum;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Notifications\Interfaces\NotificationFactoryInterface;
use App\Services\Notifications\Interfaces\NotificationUserFactoryInterface;
use App\Services\Notifications\Resources\CreateNotificationResource;
use App\Services\Notifications\Resources\CreateNotificationUserResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class NotificationFactoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private mixed $morph,
        private string $link,
        private string $title,
        private int $userId,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function handle(
        NotificationFactoryInterface $notificationFactory,
        NotificationUserFactoryInterface $notificationUserFactory,
        UserRepositoryInterface $userRepository
    ): void {
        $user = $userRepository->find($this->userId);

        if ($user === null) {
            return;
        }

        $notificationResource = new CreateNotificationResource([
            'morphable' => $this->morph,
            'link' => $this->link,
            'statusEnum' => new NotificationStatusEnum(NotificationStatusEnum::NEW),
            'title' => $this->title,
        ]);

        $notification = $notificationFactory->make($notificationResource);

        $notificationUserFactory->make(new CreateNotificationUserResource([
            'notification' => $notification,
            'user' => $user,
        ]));
    }
}
