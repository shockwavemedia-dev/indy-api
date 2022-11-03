<?php

declare(strict_types=1);

namespace App\Services\Tickets\Interfaces\Factories;

use App\Models\Tickets\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface TicketServicesFactoryInterface
{
    public function make(Collection $clientServices, Ticket $ticket, User $user, array $services): void;
}
