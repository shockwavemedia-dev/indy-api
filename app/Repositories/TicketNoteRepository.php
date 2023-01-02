<?php

namespace App\Repositories;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketNote;
use App\Models\User;
use App\Repositories\Interfaces\TicketNoteRepositoryInterface;
use App\Services\TicketNotes\Resources\UpdateTicketNoteResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TicketNoteRepository extends BaseRepository implements TicketNoteRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new TicketNote());
    }

    public function findAllTicketNotes(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model
            ->with('createdBy')
            ->where('ticket_id', '=', $ticket->getId())
            ->orderBy('id', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function deleteTicketNote(TicketNote $ticketNote, User $user): void
    {
        $ticketNote->delete();
        $ticketNote->updatedUser()->associate($user);
        $ticketNote->save();
    }

    public function updateTicketNote(TicketNote $ticketNote, UpdateTicketNoteResource $resource): TicketNote
    {
        $ticketNote->setNote($resource->getNote())
            ->setUpdatedBy($resource->getUpdatedBy());
        $ticketNote->save();

        return $ticketNote;
    }
}
