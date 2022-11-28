<?php

declare(strict_types=1);

namespace App\Services\TicketNotes\Resources;

use App\Models\Tickets\Ticket;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateTicketNoteResource extends DataTransferObject
{
    public Ticket $ticket;

    public User $createdBy;

    public string $note;

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function setTicket(Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function setCreatedBy(User $user): self
    {
        $this->createdBy = $user;

        return $this;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
