<?php

declare(strict_types=1);

namespace App\Services\TicketNotes\Resources;

use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class UpdateTicketNoteResource extends DataTransferObject
{
    public string $note;

    public User $updatedBy;


    public function getNote(): string
    {
        return $this->note;
    }

    public function getUpdatedBy(): User
    {
        return $this->updatedBy;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function setUpdatedBy(User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

}
