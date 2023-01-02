<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketAssignees;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class RemoveTicketAssigneeController extends AbstractAPIController
{
    private TicketAssigneeRepositoryInterface $ticketAssigneeRepository;

    public function __construct(
        TicketAssigneeRepositoryInterface $ticketAssigneeRepository
    ) {
        $this->ticketAssigneeRepository = $ticketAssigneeRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        try {
            $this->ticketAssigneeRepository->deleteById($id);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
