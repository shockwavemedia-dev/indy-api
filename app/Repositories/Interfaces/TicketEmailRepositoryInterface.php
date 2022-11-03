<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Tickets\TicketEmail;
use App\Models\Tickets\Ticket;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TicketEmailRepositoryInterface
{
    public function findByTicket(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function markAsRead(TicketEmail $ticketEmail, User $user, $markAsRead): TicketEmail;
}
