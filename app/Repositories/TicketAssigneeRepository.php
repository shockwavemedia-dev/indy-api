<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\TicketAssigneeStatusEnum;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketAssignee;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Services\Tickets\Resources\UpdateTicketAssigneeResource;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

final class TicketAssigneeRepository extends BaseRepository implements TicketAssigneeRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new TicketAssignee());
    }

    /**
     * @throws Exception
     */
    public function assignTicket(AdminUser $adminUser, AdminUser $createdBy, Ticket $ticket): TicketAssignee
    {
        $assignee = new TicketAssignee();

        if ($adminUser->getDepartments()->count() === 0) {
            throw new Exception('Staff does not have department.');
        }

        if ($adminUser->getDepartments()->first() !== null) {
            $assignee->department()->associate($adminUser->getDepartments()->first());
        }

        $assignee->setStatus(new TicketAssigneeStatusEnum(TicketAssigneeStatusEnum::OPEN));
        $assignee->adminUser()->associate($adminUser);
        $assignee->createdBy()->associate($createdBy);
        $assignee->ticket()->associate($ticket);
        $assignee->save();

        $ticket->updatedBy()->associate($createdBy->getUser());
        $ticket->save();

        return $assignee;
    }

    public function findByAdminUserAndTicket(Ticket $ticket, AdminUser $adminUser): ?TicketAssignee
    {
        return $this->model
            ->where('ticket_id', $ticket->getId())
            ->where('admin_user_id', $adminUser->getId())
            ->first();
    }

    public function findByTicket(Ticket $ticket, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model->where('ticket_id', '=', $ticket->getId())
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findWithDepartments(int $id): ?TicketAssignee
    {
        return $this->model->where('id', '=', $id)->with('department')->first();
    }

    public function deleteByAdminUserAndTicket(Ticket $ticket, AdminUser $adminUser): void
    {
        $this->model
            ->where('ticket_id', $ticket->getId())
            ->where('admin_user_id', $adminUser->getId())
            ->delete();
    }

    public function deleteById(int $id): void
    {
        $this->model
            ->where('id', $id)
            ->delete();
    }

    public function update(
        TicketAssignee $ticketAssignee,
        UpdateTicketAssigneeResource $resource,
        AdminUser $adminUser
    ): TicketAssignee {
        if ($resource->getStatusEnum() !== null) {
            $ticketAssignee->setStatus($resource->getStatusEnum());
        }

        if ($resource->getAdminUser() !== null) {
            $ticketAssignee->adminUser()->associate($resource->getAdminUser());
        }

        $ticketAssignee->updatedBy()->associate($adminUser);

        $ticketAssignee->save();

        return $ticketAssignee;
    }
}
