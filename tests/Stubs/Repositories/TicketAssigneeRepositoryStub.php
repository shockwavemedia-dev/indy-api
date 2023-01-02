<?php

declare(strict_types=1);

namespace Tests\Stubs\Repositories;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketAssignee;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Services\Tickets\Resources\UpdateTicketAssigneeResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class TicketAssigneeRepositoryStub extends AbstractStub implements TicketAssigneeRepositoryInterface
{
    /**
     * @throws \Throwable
     */
    public function assignTicket(AdminUser $adminUser, AdminUser $createdBy, Ticket $ticket): TicketAssignee
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function find(int $id): TicketAssignee
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByAdminUserAndTicket(Ticket $ticket, AdminUser $adminUser): ?TicketAssignee
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findByTicket(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function deleteByAdminUserAndTicket(Ticket $ticket, AdminUser $adminUser): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function deleteById(int $id): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function update(
        TicketAssignee $ticketAssignee,
        UpdateTicketAssigneeResource $resource,
        AdminUser $adminUser
    ): TicketAssignee {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function findWithDepartments(int $id): ?TicketAssignee
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
