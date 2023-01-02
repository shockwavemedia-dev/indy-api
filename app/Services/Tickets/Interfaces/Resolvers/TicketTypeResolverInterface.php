<?php

declare(strict_types=1);

namespace App\Services\Tickets\Interfaces\Resolvers;

use App\Enum\TicketTypeEnum;
use App\Models\Tickets\Ticket;
use App\Services\Tickets\Resources\CreateTicketResource;

interface TicketTypeResolverInterface
{
    public function create(CreateTicketResource $resource): Ticket;

    public function supports(TicketTypeEnum $type): bool;
}
