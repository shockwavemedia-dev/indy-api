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
use function Clue\StreamFilter\fun;

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
        return $this->model->where('client_id', $client->getId())->count();
    }


    public function countNewTicketByDepartment(Department $department): int
    {
        return $this->model
            ->with('ticketServices.service')
            ->where('status', '=', TicketStatusEnum::NEW)
            ->where('department_id', $department->getId())
            ->orWhereHas('assignees', function($query) use ($department){
                $query->where('department_id', '=',$department->getId());
            })
            ->orWhereHas('ticketServices.service.departments', function($query) use ($department){
                $query->where('department_id', '=',$department->getId());
            })->count();
    }

    public function countOpenTicketByDepartment(Department $department): int
    {
        return $this->model
        ->with('ticketServices.service')
        ->where('status', '=', TicketStatusEnum::OPEN)
        ->where('department_id', $department->getId())
        ->orWhereHas('assignees', function($query) use ($department){
            $query->where('department_id', '=',$department->getId());
        })
        ->orWhereHas('ticketServices.service.departments', function($query) use ($department){
            $query->where('department_id', '=',$department->getId());
        })->count();
    }

    public function countOpenTicketByClient(Client $client): int
    {
        return $this->model
            ->where('client_id', $client->getId())
            ->where('status', '=', TicketStatusEnum::PENDING)
            ->count();
    }

    public function deleteTicketSupport(Ticket $ticket, User $user): void
    {
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

        return $this->model
            ->with('ticketServices.service')
            ->when($types, function ($query, $types) {
                return $query->whereIn('type', $types);
            })
            ->when($statuses, function ($query, $statuses) {
                return $query->whereIn('status', $statuses);
            })
            ->when($subject, function ($query, $subject) {
                return $query->where('subject', 'LIKE', '%' . $subject . '%');
            })
            ->when($code, function ($query, $code) {
                return $query->where('ticket_code', 'LIKE', '%' . $code . '%');
            })
            ->when($deadline, function ($query, $deadline) {
                return $query->whereBetween('duedate',[
                    \sprintf('%s 00:00:00',$deadline->toDateString()),
                    \sprintf('%s 00:00:00',$deadline->addDays(2)->toDateString())
                ]);
            })
            ->where('client_id', $client->getId())
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findByDepartment(Department $department, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model
            ->with('ticketServices.service')
            ->where('department_id', $department->getId())
            ->orWhereHas('assignees', function($query) use ($department){
                $query->where('department_id', '=',$department->getId());
            })
            ->orWhereHas('ticketServices.service.departments', function($query) use ($department){
                $query->where('department_id', '=',$department->getId());
            })
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findWithFiles(int $id): ?Ticket
    {
        return $this->model
            ->where('id', '=', $id)
            ->whereHas('clientTicketFiles', function ($query) use ($id)  {
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
            ->whereHas('department', function ($query)  {
                $query->where('name', '=', 'Graphics Department');
            })
            ->whereHas('ticketServices.service', function ($query)  {
                $query->where('name', '=', ServicesEnum::GRAPHIC_DESIGN);
            })
            ->where('client_id', $client->getId())
            ->where('type', TicketTypeEnum::GRAPHIC)
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findWebsiteTicketsByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        return $this->model
            ->with('ticketServices.service')
            ->orWhereHas('department', function ($query)  {
                $query->where('name', '=', 'Website Department');
            })
            ->orWhereHas('ticketServices.service', function ($query)  {
                $query->where('name', '=', ServicesEnum::WEBSITE);
            })
            ->where('client_id', $client->getId())
            ->orderBy('created_at', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findSupportTickets(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($size, ['*'], null, $pageNumber);
    }

    public function findByOptions(
        array $params = [],
        ?int $size = null,
        ?int $pageNumber = null,
        ?Client $client = null
    ): LengthAwarePaginator {
        $departmentIds = Arr::get($params, 'department_ids');

        $types = Arr::get($params, 'types');

        $status = Arr::get($params, 'status');

        return $this->model
            ->when($client, function ($query, $client) {
                if ($client === null) {
                    return;
                }

                $query->where('client_id', $client->getId());
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

    public function findByAssigneeAdminUser(AdminUser $adminUser, ?int $size = null, ?int $pageNumber = null): LengthAwarePaginator
    {
        return $this->model->whereHas('assignees', function($query) use ($adminUser){
            $query->where('admin_user_id', '=',$adminUser->getId());
        })
            ->with('ticketServices.service')
            ->orderBy('id', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function findDepartmentTicketCountByStatusAndMonth(Department $department): ?Collection
    {
        return $this->model
            ->select([ DB::raw('count(*) as ticket_counts,status,DATE_FORMAT(created_at, "%M = %Y") as date')])
            ->orWhere('department_id', $department->getId())
            ->orWhereHas('assignees', function($query) use ($department){
                $query->where('department_id', '=',$department->getId());
            })
            ->orWhereHas('ticketServices.service.departments', function($query) use ($department){
                $query->where('department_id', '=',$department->getId());
            })
            ->groupBy(['status', DB::raw('DATE_FORMAT(created_at, "%M = %Y")')])
            ->get();
    }

    public function updateStatusToOpen(Ticket $ticket): Ticket
    {
        $ticket->setStatus(new TicketStatusEnum(TicketStatusEnum::OPEN));
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

        $userNotes[$user->getId()] =  $userNotes[$user->getId()] + 1;

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

        $userNotes[$user->getId()] =  0;

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

            $userNotes[$userNote] = $count+1;
        }

        $ticket->setAttribute('user_notes', json_encode($userNotes));

        $ticket->save();

        return $ticket;
    }
}
