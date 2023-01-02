<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketNote;
use App\Models\User;
use App\Repositories\Interfaces\TicketNoteRepositoryInterface;
use App\Services\TicketNotes\Resources\UpdateTicketNoteResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketNoteRepositoryStub extends AbstractStub implements TicketNoteRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function create(array $attributes): Model
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findAllTicketNotes(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function deleteTicketNote(TicketNote $ticketNote, User $user): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function updateTicketNote(TicketNote $ticketNote, UpdateTicketNoteResource $resource): TicketNote
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
