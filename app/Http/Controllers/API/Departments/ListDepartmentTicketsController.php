<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Departments;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Tickets\TicketSupportsResource;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListDepartmentTicketsController extends AbstractAPIController
{
    private DepartmentRepositoryInterface $departmentRepository;
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->ticketRepository = $ticketRepository;
    }

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
            $request->getSize(),
            $request->getPageNumber()
        );

        return new TicketSupportsResource($tickets);
    }
}
