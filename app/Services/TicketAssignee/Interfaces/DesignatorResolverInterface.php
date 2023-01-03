<?php

namespace App\Services\TicketAssignee\Interfaces;

use App\Enum\ServicesEnum;
use App\Models\Tickets\Ticket;

interface DesignatorResolverInterface
{
    public function resolve(Ticket $ticket): void;

    public function supports(ServicesEnum $serviceType): bool;
}
