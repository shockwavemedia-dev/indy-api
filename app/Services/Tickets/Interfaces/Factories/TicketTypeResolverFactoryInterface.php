<?php

declare(strict_types=1);

namespace App\Services\Tickets\Interfaces\Factories;

use App\Enum\TicketTypeEnum;
use App\Services\Tickets\Interfaces\Resolvers\TicketTypeResolverInterface;

interface TicketTypeResolverFactoryInterface
{
    public function make(TicketTypeEnum $type): TicketTypeResolverInterface;
}
