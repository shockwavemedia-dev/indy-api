<?php

declare(strict_types=1);

namespace App\Services\TicketChats\Resources;

use App\Models\Tickets\Ticket;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateTicketChatResource extends DataTransferObject
{
    public User $user;

    public Ticket $ticket;

    public string $message;

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
