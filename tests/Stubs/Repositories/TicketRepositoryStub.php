<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\Client;
use App\Models\Department;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\Tickets\Resources\TicketFilterOptionsResource;
use App\Services\Tickets\Resources\UpdateTicketResource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketRepositoryStub extends AbstractStub implements TicketRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function create(array $attributes): Model
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function countNewTicketByClient(Client $client): int
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function countOpenTicketByClient(Client $client): int
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function countTicketByClient(Client $client): int
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function countNewTicketByDepartment(Department $department, AdminUser $adminUser): int
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function countOpenTicketByDepartment(Department $department, AdminUser $adminUser): int
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function deleteTicketSupport(Ticket $ticket, User $user): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByClient(Client $client, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByDepartment(Department $department, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findWithFiles(int $id): ?Ticket
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByOptions(TicketFilterOptionsResource $resource, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findSupportTickets(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function update(Ticket $ticket, UpdateTicketResource $resource): Ticket
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findGraphicsTicketByClient(Client $client, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByAssigneeAdminUser(AdminUser $adminUser, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findLibraryTicketsByClient(Client $client, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findDepartmentTicketCountByStatusAndMonth(Department $department): ?Collection
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findWebsiteTicketsByClient(Client $client, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function updateStatusToOpen(Ticket $ticket): Ticket
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function addUserNotes(Ticket $ticket, User $user): Ticket
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function removeUserNotes(Ticket $ticket, User $user): Ticket
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function increaseUserNotes(Ticket $ticket, User $user): Ticket
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function resetUserNotes(Ticket $ticket, User $user): Ticket
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function increaseUserNotesExceptSender(Ticket $ticket, User $user): Ticket
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    public function findWithFileVersions(int $id): ?Ticket
    {
        // TODO: Implement findWithFileVersions() method.
    }

    /**
     * @throws \Throwable
     */
    public function updateIsApprovalRequired(Ticket $ticket, bool $isApprovalRequired): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }

    public function findWithChats(int $id): ?Ticket
    {
        // TODO: Implement findWithChats() method.
    }
}
