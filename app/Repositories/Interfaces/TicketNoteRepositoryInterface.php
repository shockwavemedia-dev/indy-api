<?php

namespace App\Repositories\Interfaces;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketNote;
use App\Models\User;
use App\Services\TicketNotes\Resources\UpdateTicketNoteResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TicketNoteRepositoryInterface
{
    public function findAllTicketNotes(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function deleteTicketNote(TicketNote $ticketNote, User $user): void;

    public function updateTicketNote(TicketNote $ticketNote, UpdateTicketNoteResource $resource): TicketNote;
}
