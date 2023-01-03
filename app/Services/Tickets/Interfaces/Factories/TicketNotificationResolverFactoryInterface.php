<?php

namespace App\Services\Tickets\Interfaces\Factories;

use App\Enum\TicketNotificationTypeEnum;
use App\Services\Tickets\Interfaces\Resolvers\TicketNotificationResolverInterface;

interface TicketNotificationResolverFactoryInterface
{
    public function make(TicketNotificationTypeEnum $typeEnum): TicketNotificationResolverInterface;
}
