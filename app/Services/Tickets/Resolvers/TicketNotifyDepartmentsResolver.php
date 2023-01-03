<?php

declare(strict_types=1);

namespace App\Services\Tickets\Resolvers;

use App\Enum\TicketNotificationTypeEnum;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketService;
use App\Services\Departments\Interfaces\DepartmentTicketNotificationHandlerInterface;
use App\Services\Tickets\Interfaces\Resolvers\TicketNotifyDepartmentsResolverInterface;

final class TicketNotifyDepartmentsResolver implements TicketNotifyDepartmentsResolverInterface
{
    private DepartmentTicketNotificationHandlerInterface $departmentTicketNotificationHandler;

    public function __construct(DepartmentTicketNotificationHandlerInterface $departmentTicketNotificationHandler)
    {
        $this->departmentTicketNotificationHandler = $departmentTicketNotificationHandler;
    }

    public function resolve(Ticket $ticket, TicketNotificationTypeEnum $typeEnum): void
    {
        if ($ticket->getDepartment() !== null) {
            $this->departmentTicketNotificationHandler->handle($ticket->getDepartment(), $ticket, $typeEnum);

            return;
        }

        $ticketServices = $ticket->getTicketServices();

        /** @var TicketService $ticketService */
        foreach ($ticketServices as $ticketService) {
            $departments = $ticketService->getService()->getDepartments();

            foreach ($departments as $department) {
                $this->departmentTicketNotificationHandler->handle($department, $ticket, $typeEnum);
            }
        }
    }
}
