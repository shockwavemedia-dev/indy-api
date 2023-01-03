<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasRelationshipWithUser
{
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function getCreatedById(): int
    {
        return $this->getAttribute('created_by');
    }

    public function getUpdatedById(): int
    {
        return $this->getAttribute('updated_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function setCreatedBy(User $user): self
    {
        $this->createdBy()->associate($user);

        return $this;
    }

    public function setUpdatedBy(User $user): self
    {
        $this->updatedBy()->associate($user);

        return $this;
    }
}
