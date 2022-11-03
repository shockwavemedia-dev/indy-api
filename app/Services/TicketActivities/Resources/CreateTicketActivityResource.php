<?php

declare(strict_types=1);

namespace App\Services\TicketActivities\Resources;

use App\Models\Tickets\Ticket;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateTicketActivityResource extends DataTransferObject
{
    public Ticket $ticket;

    public User $user;

    public string $activity;

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getActivity(): string
    {
        return $this->activity;
    }

    public function setTicket(Ticket $ticket): self
    {
        $this->ticket = $ticket;
        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function setActivity(string $activity): self
    {
        $this->activity = $activity;
        return $this;
    }
}
