<?php

declare(strict_types=1);

namespace App\Services\Notifications\Resources;

use App\Enum\NotificationStatusEnum;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateNotificationResource extends DataTransferObject
{
    public NotificationStatusEnum $statusEnum;

    public ?string $description;

    public ?string $link;

    public mixed $morphable;

    public string $title;

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getStatusEnum(): NotificationStatusEnum
    {
        return $this->statusEnum;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getMorphable(): mixed
    {
        return $this->morphable;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setStatusEnum(NotificationStatusEnum $statusEnum): self
    {
        $this->statusEnum = $statusEnum;
        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;
        return $this;
    }

    public function setMorphable(mixed $morphable): self
    {
        $this->morphable = $morphable;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
}
