<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketAssignee;
use App\Models\Users\AdminUser;
use App\Services\Tickets\Resources\UpdateTicketAssigneeResource;
use Illuminate\Pagination\LengthAwarePaginator;

interface TicketAssigneeRepositoryInterface
{
    public function assignTicket(AdminUser $adminUser, AdminUser $createdBy, Ticket $ticket): TicketAssignee;

    public function findWithDepartments(int $id): ?TicketAssignee;

    public function findByAdminUserAndTicket(Ticket $ticket, AdminUser $adminUser): ?TicketAssignee;

    public function findByTicket(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function deleteByAdminUserAndTicket(Ticket $ticket, AdminUser $adminUser): void;

    public function deleteById(int $id): void;

    public function update(
        TicketAssignee $ticketAssignee,
        UpdateTicketAssigneeResource $resource,
        AdminUser $adminUser
    ): TicketAssignee;
}
