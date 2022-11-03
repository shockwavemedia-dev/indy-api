<?php

namespace App\Services\Tickets\Interfaces\Resolvers;

use App\Enum\TicketNotificationTypeEnum;
use App\Models\Tickets\Ticket;

interface TicketNotifyDepartmentsResolverInterface
{
    public function resolve(Ticket $ticket, TicketNotificationTypeEnum $typeEnum): void;
}
