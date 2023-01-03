<?php

declare(strict_types=1);

namespace App\Services\Screens\Resources;

use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateScreenResource extends DataTransferObject
{
    public string $name;

    public string $slug;

    public ?int $logoFileId;

    public User $createdBy;

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getLogoFileId(): ?int
    {
        return $this->logoFileId;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }
}
