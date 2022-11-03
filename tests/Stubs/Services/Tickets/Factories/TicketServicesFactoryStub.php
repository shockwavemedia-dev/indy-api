<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\Tickets\Factories;

use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Services\Tickets\Interfaces\Factories\TicketServicesFactoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketServicesFactoryStub extends AbstractStub implements TicketServicesFactoryInterface
{
    /**
     * @throws \Throwable
     */
    public function make(Collection $clientServices, Ticket $ticket, User $user, array $services): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }
}
