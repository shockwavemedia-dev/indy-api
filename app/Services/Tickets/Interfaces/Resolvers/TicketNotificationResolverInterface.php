<?php

namespace App\Services\Tickets\Interfaces\Resolvers;

use App\Enum\TicketNotificationTypeEnum;
use App\Models\Tickets\Ticket;
use App\Models\User;

interface TicketNotificationResolverInterface
{
    public function resolve(Ticket $ticket, User $user): void;

    public function supports(TicketNotificationTypeEnum $typeEnum): bool;
}
