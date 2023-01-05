<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\ServicesEnum;
use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

final class TicketRepository extends BaseRepository implements TicketRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Ticket());
    }

    public function countNewTicketByClient(Client $client): int
    {
        return $this->model
            ->where('client_id', $client->getId())
            ->where('status', '=', TicketStatusEnum::NEW)
            ->count();
    }

    public function countTicketByClient(Client $client): int
    {
        return $this->model->where('client_id', $client->getId())->withTrashed()->count();
    }

    public function countNewTicketByDepartment(Department $department, AdminUser $adminUser): int
    {
        return $this->model
            ->with('ticketServices.service')
            ->where('status', '=', TicketStatusEnum::NEW)
            ->where('department_id', $department->getId())
            ->orWhereHas('assignees', function ($query) use ($department, $adminUser) {
                $query->where('department_id', '=', $department->getId());
                $query->where('admin_user_id', '=', $adminUser->getId());
            })
            ->orWhereHas('ticketServices.service.departments', function ($query) use ($department) {
                $query->where('department_id', '=', $department->getId());
            })->count();
    }

    public function countOpenTicketByDepartment(Department $department, AdminUser $adminUser): int
    {
        return $this->model
        ->with('ticketServices.service')
        ->where('status', '=', TicketStatusEnum::OPEN)
        ->where('department_id', $department->getId())
        ->orWhereHas('assignees', function ($query) use ($department, $adminUser) {
            $query->where('department_id', '=', $department->getId());
            $query->where('admin_user_id', '=', $adminUser->getId());
        })
        ->orWhereHas('ticketServices.service.departments', function ($query) use ($department) {
            $query->where('department_id', '=', $department->getId());
        })->count();
    }

    public function countOpenTicketByClient(Client $client): int
    {
        return $this->model
            ->where('client_id', $client->getId())
            ->whereIn('status', [
                TicketStatusEnum::OPEN,
                TicketStatusEnum::PENDING,
                TicketStatusEnum::IN_PROGRESS,
            ])
            ->count();
    }

    public function deleteTicketSupport(Ticket $ticket, User $user): void
    {
        $ticket->assignees()->delete();
        $ticket->delete();
        $ticket->updatedBy()->associate($user);
        $ticket->setStatus(new TicketStatusEnum(TicketStatusEnum::DELETED));
        $ticket->save();
    }

    public function findByClient(
        Client $client,
        TicketFilterOptionsResource $resource,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        $types = $resource->getTypes();

        $statuses = $resource->getStatuses();

        $subject = $resource->getSubject();

        $code = $resource->getCode();

        $deadline = $resource->getDeadline();

        $priorities = $resource->getPriorities();

        $hideClosed = $resource->hideClosed();

        return $this->model
            ->with('ticketServices.service')
            ->when($types, function ($query, $types) {
                return $query->whereIn('type', $types);
            })
            ->when($statuses, function ($query, $statuses) {
                return $query->whereIn('status', $statuses);
            })
            ->when($subject, function ($query, $subject) {
                return $query->where('subject', 'LIKE', '%'.$subject.'%');
            })
            ->when($code, function ($query, $code) {
                return $query->where('ticket_code', 'LIKE', '%'.$code.'%');
            })
            ->when($deadline, function ($query, $deadline) {
                return $query->whereBetween('duedate', [
                    \sprintf('%s 00:00:00', $deadline->toDateString()),
                    \sprintf('%s 00:00:00', $deadline->addDays(2)->toDateString()),
                ]);
            })
            ->where('client_id', $client->getId())
            ->when($priorities, function ($query, $priorities) {
                return $query->whereIn('priority', $priorities);
            })
            ->when($hideClosed, function ($query) use ($hideClosed) {
                if ($hideClosed === null) {
                    return;
                }

                $query->where('status', '!=', TicketStatusEnum::CLOSED);
            })
            ->orderBy('id', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findByDepartment(
        Department $department,
        TicketFilterOptionsResource $resource,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        $statuses = $resource->getStatuses();

        $priorities = $resource->getPriorities();

        $clientId = $resource->getClientId();

        $hideClosed = $resource->hideClosed();

        $types = $resource->getTypes();

        $subject = $resource->getSubject();

        $code = $resource->getCode();

        $deadline = $resource->getDeadline();

        return $this->model
            ->with('ticketServices.service')
            ->where('department_id', $department->getId())
            ->orWhereHas('assignees', function ($query) use ($department) {
                $query->where('department_id', '=', $department->getId());
            })
            ->when($statuses, function ($query) use ($statuses) {
                return $query->whereIn('status', $statuses);
            })
            ->when($clientId, function ($query) use ($clientId) {
                if ($clientId === null) {
                    return;
                }

                $query->where('client_id', $clientId);
            })
            ->when($priorities, function ($query, $priorities) {
                return $query->whereIn('priority', $priorities);
            })
            ->when($hideClosed, function ($query) use ($hideClosed) {
                if ($hideClosed === null) {
                    return;
                }

                $query->where('status', '!=', TicketStatusEnum::CLOSED);
            })
            ->when($types, function ($query, $types) {
                return $query->whereIn('type', $types);
            })
            ->when($subject, function ($query, $subject) {
                return $query->where('subject', 'LIKE', '%'.$subject.'%');
            })
            ->when($code, function ($query, $code) {
                return $query->where('ticket_code', 'LIKE', '%'.$code.'%');
            })
            ->when($deadline, function ($query, $deadline) {
                return $query->whereBetween('duedate', [
                    \sprintf('%s 00:00:00', $deadline->toDateString()),
                    \sprintf('%s 00:00:00', $deadline->addDays(2)->toDateString()),
                ]);
            })
            ->orWhereHas('ticketServices.service.departments', function ($query) use ($department) {
                $query->where('department_id', '=', $department->getId());
            })
            ->orderBy('id', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findWithFiles(int $id): ?Ticket
    {
        return $this->model
            ->where('id', '=', $id)
            ->whereHas('clientTicketFiles', function ($query) use ($id) {
                $query->where('ticket_id', '=', $id);
            })
            ->with(['clientTicketFiles.file'])
            ->first();
    }

    public function findLibraryTicketsByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        return $this->model
            ->with('ticketServices.service')
            ->where('type', TicketTypeEnum::LIBRARY)
            ->where('client_id', $client->getId())
            ->where('type', TicketTypeEnum::LIBRARY)
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findGraphicsTicketByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        return $this->model
            ->with('ticketServices.service')
            ->whereHas('department', function ($query) {
                $query->where('name', '=', 'Graphics Department');
            })
            ->whereHas('ticketServices.service', function ($query) {
                $query->where('name', '=', ServicesEnum::GRAPHIC_DESIGN);
            })
            ->where('client_id', $client->getId())
            ->where('type', TicketTypeEnum::GRAPHIC)
            ->orderBy('id', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findWebsiteTicketsByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        return $this->model
            ->with('ticketServices.service')
            ->orWhereHas('department', function ($query) {
                $query->where('name', '=', 'Website Department');
            })
            ->orWhereHas('ticketServices.service', function ($query) {
                $query->where('name', '=', ServicesEnum::WEBSITE);
            })
            ->where('client_id', $client->getId())
            ->orderBy('id', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findSupportTickets(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model->orderBy('id', 'desc')->paginate($size, ['*'], null, $pageNumber);
    }

    public function findByOptions(
        array $params = [],
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        $departmentIds = Arr::get($params, 'department_ids');

        $types = Arr::get($params, 'types');

        $status = Arr::get($params, 'status');

        $priority = Arr::get($params, 'priority');

        $clientId = Arr::get($params, 'client_id');

        return $this->model
            ->when($clientId, function ($query) use ($clientId) {
                if ($clientId === null) {
                    return;
                }

                $query->where('client_id', $clientId);
            })
            ->when($types, function ($query, $types) {
                return $query->whereIn('type', $types);
            })
            ->when($status, function ($query, $status) {
                return $query->whereIn('status', $status);
            })
            ->when($departmentIds, function ($query, $departmentIds) {
                return $query->whereIn('department_id', $departmentIds);
            })
            ->when($priority, function ($query, $priority) {
                return $query->whereIn('priority', $priority);
            })
            ->with('ticketEvent')
            ->orderBy('id', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function update(Ticket $ticket, UpdateTicketResource $resource): Ticket
    {
        $ticket->setSubject($resource->getSubject())
            ->setDescription($resource->getDescription())
            ->setType($resource->getType())
            ->setDueDate($resource->getDueDate())
            ->setStatus($resource->getStatus())
            ->setUpdatedBy($resource->getUpdatedBy())
            ->setPriority($resource->getPriority());
        $ticket->save();

        return $ticket;
    }

    public function findByAdminUser(
        AdminUser $adminUser,
        TicketFilterOptionsResource $resource,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        $statuses = $resource->getStatuses();

        $priorities = $resource->getPriorities();

        $clientId = $resource->getClientId();

        $hideClosed = $resource->hideClosed();

        $types = $resource->getTypes();

        $subject = $resource->getSubject();

        $code = $resource->getCode();

        $deadline = $resource->getDeadline();

        return $this->model->whereHas('assignees', function ($query) use ($adminUser) {
            $query->where('admin_user_id', '=', $adminUser->getId());
        })
            ->with('ticketServices.service')
            ->when($statuses, function ($query) use ($statuses) {
                return $query->whereIn('status', $statuses);
            })
            ->when($clientId, function ($query) use ($clientId) {
                if ($clientId === null) {
                    return;
                }

                $query->where('client_id', $clientId);
            })
            ->when($priorities, function ($query, $priorities) {
                return $query->whereIn('priority', $priorities);
            })
            ->when($hideClosed, function ($query) use ($hideClosed) {
                if ($hideClosed === null) {
                    return;
                }

                $query->where('status', '!=', TicketStatusEnum::CLOSED);
            })
            ->when($types, function ($query, $types) {
                return $query->whereIn('type', $types);
            })
            ->when($subject, function ($query, $subject) {
                return $query->where('subject', 'LIKE', '%'.$subject.'%');
            })
            ->when($code, function ($query, $code) {
                return $query->where('ticket_code', 'LIKE', '%'.$code.'%');
            })
            ->when($deadline, function ($query, $deadline) {
                return $query->whereBetween('duedate', [
                    \sprintf('%s 00:00:00', $deadline->toDateString()),
                    \sprintf('%s 00:00:00', $deadline->addDays(2)->toDateString()),
                ]);
            })
            ->orderBy('id', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findDepartmentTicketCountByStatusAndMonth(Department $department): ?Collection
    {
        return $this->model
            ->select([DB::raw('count(*) as ticket_counts,status,DATE_FORMAT(created_at, "%M = %Y") as date')])
            ->orWhere('department_id', $department->getId())
            ->orWhereHas('assignees', function ($query) use ($department) {
                $query->where('department_id', '=', $department->getId());
            })
            ->orWhereHas('ticketServices.service.departments', function ($query) use ($department) {
                $query->where('department_id', '=', $department->getId());
            })
            ->groupBy(['status', DB::raw('DATE_FORMAT(created_at, "%M = %Y")')])
            ->get();
    }

    public function updateStatusToOpen(Ticket $ticket): Ticket
    {
        $ticket->setStatus(new TicketStatusEnum(TicketStatusEnum::OPEN));
        $ticket->setUpdatedBy(null);
        $ticket->save();

        return $ticket;
    }

    public function addUserNotes(Ticket $ticket, User $user): Ticket
    {
        $userNotes = $ticket->getUserNotes();

        $userNotes[$user->getId()] = 0;

        $ticket->setAttribute('user_notes', json_encode($userNotes));

        $ticket->save();

        return $ticket;
    }

    public function removeUserNotes(Ticket $ticket, User $user): Ticket
    {
        $userNotes = $ticket->getUserNotes();

        unset($userNotes[$user->getId()]);

        $ticket->setAttribute('user_notes', json_encode($userNotes));

        $ticket->save();

        return $ticket;
    }

    public function increaseUserNotes(Ticket $ticket, User $user): Ticket
    {
        $userNotes = $ticket->getUserNotes();

        if (isset($userNotes[$user->getId()]) === false) {
            return $ticket;
        }

        $userNotes[$user->getId()] = $userNotes[$user->getId()] + 1;

        $ticket->setAttribute('user_notes', json_encode($userNotes));

        $ticket->save();

        return $ticket;
    }

    public function resetUserNotes(Ticket $ticket, User $user): Ticket
    {
        $userNotes = $ticket->getUserNotes();

        if (isset($userNotes[$user->getId()]) === false) {
            return $ticket;
        }

        $userNotes[$user->getId()] = 0;

        $ticket->setAttribute('user_notes', json_encode($userNotes));

        $ticket->save();

        return $ticket;
    }

    public function increaseUserNotesExceptSender(Ticket $ticket, User $user): Ticket
    {
        $userNotes = $ticket->getUserNotes();

        foreach ($userNotes as $userNote => $count) {
            if ((int) $userNote === $user->getId()) {
                continue;
            }

            $userNotes[$userNote] = $count + 1;
        }

        $ticket->setAttribute('user_notes', json_encode($userNotes));

        $ticket->save();

        return $ticket;
    }

    public function findWithFileVersions(int $id): ?Ticket
    {
        return $this->model->where('id', $id)
            ->with('clientTicketFiles.fileVersions.file')
            ->first();
    }

    public function updateIsApprovalRequired(Ticket $ticket, bool $isApprovalRequired): void
    {
        $ticket->setIsApprovalRequired($isApprovalRequired);
        $ticket->save();
    }

    public function findWithChats(int $id): ?Ticket
    {
        return $this->model
            ->where('id', '=', $id)
            ->with(['chats.createdBy'])
            ->first();
    }
}
