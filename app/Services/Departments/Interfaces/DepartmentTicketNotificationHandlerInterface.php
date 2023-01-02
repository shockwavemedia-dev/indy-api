<?php

namespace App\Services\Departments\Interfaces;

use App\Enum\TicketNotificationTypeEnum;
use App\Models\Department;
use App\Models\Tickets\Ticket;

interface DepartmentTicketNotificationHandlerInterface
{
    public function handle(
        Department $department,
        Ticket $ticket,
        TicketNotificationTypeEnum $typeEnum
    ): void;
}
