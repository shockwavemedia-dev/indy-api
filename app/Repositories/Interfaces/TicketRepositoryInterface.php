<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\Department;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Services\Tickets\Resources\TicketFilterOptionsResource;
use App\Services\Tickets\Resources\UpdateTicketResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TicketRepositoryInterface
{
    public function countNewTicketByClient(Client $client): int;

    public function countOpenTicketByClient(Client $client): int;

    public function countNewTicketByDepartment(Department $department): int;

    public function countOpenTicketByDepartment(Department $department): int;

    public function countTicketByClient(Client $client): int;

    public function deleteTicketSupport(Ticket $ticket, User $user): void;

    public function findByClient(
        Client $client,
        TicketFilterOptionsResource $resource,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator;

    public function findByDepartment(
        Department $department,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator;

    public function findWithFiles(int $id): ?Ticket;

    public function findLibraryTicketsByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator;

    public function findGraphicsTicketByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator;

    public function findWebsiteTicketsByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator;

    public function findByOptions(
        array $params = [],
        ?int $size = null,
        ?int $pageNumber = null,
        ?Client $client = null,
    ): LengthAwarePaginator;

    public function findSupportTickets(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function findDepartmentTicketCountByStatusAndMonth(Department $department): ?Collection;

    public function update(Ticket $ticket, UpdateTicketResource $resource): Ticket;

    public function updateStatusToOpen(Ticket $ticket): Ticket;

    public function findByAssigneeAdminUser(
        AdminUser $adminUser,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator;

    public function addUserNotes(Ticket $ticket, User $user): Ticket;

    public function removeUserNotes(Ticket $ticket, User $user): Ticket;

    public function increaseUserNotes(Ticket $ticket, User $user): Ticket;

    public function increaseUserNotesExceptSender(Ticket $ticket, User $user): Ticket;

    public function resetUserNotes(Ticket $ticket, User $user): Ticket;

    public function updateIsApprovalRequired(Ticket $ticket, bool $isApprovalRequired): void;
}
