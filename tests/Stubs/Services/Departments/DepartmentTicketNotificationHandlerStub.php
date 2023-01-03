<?php

namespace Tests\Stubs\Services\Departments;

use App\Enum\TicketNotificationTypeEnum;
use App\Models\Department;
use App\Models\Tickets\Ticket;
use App\Services\Departments\Interfaces\DepartmentTicketNotificationHandlerInterface;
use Tests\Stubs\AbstractStub;

final class DepartmentTicketNotificationHandlerStub extends AbstractStub implements DepartmentTicketNotificationHandlerInterface
{
    /**
     * @throws \Throwable
     */
    public function handle(Department $department, Ticket $ticket, TicketNotificationTypeEnum $typeEnum): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }
}
