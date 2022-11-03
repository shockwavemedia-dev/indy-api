<?php

namespace App\Repositories;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketActivity;
use App\Repositories\Interfaces\TicketActivityRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TicketActivityRepository extends BaseRepository implements TicketActivityRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new TicketActivity());
    }

    public function findAllTicketActivities(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model
            ->with('user')
            ->where('ticket_id', '=' , $ticket->getId())
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }
}
