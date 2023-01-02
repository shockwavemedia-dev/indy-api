<?php

namespace App\Repositories\Interfaces;

use App\Models\Tickets\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TicketActivityRepositoryInterface
{
    public function findAllTicketActivities(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;
}
