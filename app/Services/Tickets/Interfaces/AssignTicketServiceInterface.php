<?php

declare(strict_types=1);

namespace App\Services\Tickets\Interfaces;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketAssignee;
use App\Models\Users\AdminUser;

interface AssignTicketServiceInterface
{
    public function assign(
        Ticket $ticket,
        AdminUser $adminUser,
        AdminUser $createdBy,
        ?array $links
    ): TicketAssignee;
}
