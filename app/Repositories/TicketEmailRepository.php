<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketEmail;
use App\Models\User;
use App\Repositories\Interfaces\TicketEmailRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class TicketEmailRepository extends BaseRepository implements TicketEmailRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new TicketEmail());
    }

    public function findByTicket(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model->where('ticket_id', $ticket->getId())
            ->orderBy('id', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function markAsRead(TicketEmail $ticketEmail, User $user, $markAsRead): TicketEmail
    {
        $ticketEmail->markAsRead($markAsRead);
        $ticketEmail->setUpdatedBy($user);
        $ticketEmail->save();

        return $ticketEmail;
    }
}
