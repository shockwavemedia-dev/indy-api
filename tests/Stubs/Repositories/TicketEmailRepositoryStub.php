<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketEmail;
use App\Models\User;
use App\Repositories\Interfaces\TicketEmailRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketEmailRepositoryStub extends AbstractStub implements TicketEmailRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function create(array $attributes): TicketEmail
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByTicket(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function markAsRead(TicketEmail $ticketEmail, User $user, $markAsRead): TicketEmail
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
