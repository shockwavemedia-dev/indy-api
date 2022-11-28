<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

final class TicketAnalyticsController extends AbstractAPIController
{
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(int $id): JsonResponse
    {
        $department = $this->departmentRepository->find($id);

        $results = $this->ticketRepository->findDepartmentTicketCountByStatusAndMonth($department);

        $groups = [];

        foreach ($results as $data) {
            $groups[$data['date']][Str::ucfirst($data['status'])] = $data['ticket_counts'];
        }

        return new JsonResponse($groups);
    }
}
