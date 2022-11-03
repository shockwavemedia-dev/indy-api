<?php

declare(strict_types=1);

namespace App\Services\Notifications\Resources;

use App\Models\Notification;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateNotificationUserResource extends DataTransferObject
{
    public Notification $notification;

    public User $user;

    public ?string $title;

    public function getNotification(): Notification
    {
        return $this->notification;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setNotification(Notification $notification): self
    {
        $this->notification = $notification;
        return $this;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
