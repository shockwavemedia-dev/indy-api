<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Departments;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Tickets\TicketSupportsResource;
use App\Models\Department;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\Tickets\Resources\TicketFilterOptionsResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListDepartmentTicketsController extends AbstractAPIController
{
    private DepartmentRepositoryInterface $departmentRepository;

    private TicketRepositoryInterface $ticketRepository;

    private ClientRepositoryInterface $clientRepository;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        TicketRepositoryInterface $ticketRepository,
        ClientRepositoryInterface $clientRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->ticketRepository = $ticketRepository;
        $this->clientRepository = $clientRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(int $id, PaginationRequest $request): JsonResource
    {
        /** @var Department $department */
        $department = $this->departmentRepository->find($id);

        if ($department === null) {
            return $this->respondNotFound([
                'message' => 'Department not found.',
            ]);
        }

        $tickets = $this->ticketRepository->findByDepartment(
            $department,
            new TicketFilterOptionsResource([
                'statuses' => $request->getStatuses(),
                'priorities' => $request->getPriorities(),
                'clientId' => $request->getClientId(),
                'hideClosed' => $request->hideClosed(),
                'code' => $request->getCode(),
                'deadline' => $request->getDeadline(),
                'types' => $request->getTypes(),
                'subject' => $request->getSubject(),
            ]),
            $request->getSize(),
            $request->getPageNumber()
        );

        return new TicketSupportsResource($tickets);
    }
}
