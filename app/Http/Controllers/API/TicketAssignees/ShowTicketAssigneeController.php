<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketAssignees;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\TicketAssignee\TicketAssigneeResource;
use App\Models\Tickets\TicketAssignee;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowTicketAssigneeController extends AbstractAPIController
{
    private TicketAssigneeRepositoryInterface $ticketAssigneeRepository;

    public function __construct(TicketAssigneeRepositoryInterface $ticketAssigneeRepository)
    {
        $this->ticketAssigneeRepository = $ticketAssigneeRepository;

    }

    public function __invoke(int $id): JsonResource
    {
        /** @var TicketAssignee $ticketAssignee */
        $ticketAssignee = $this->ticketAssigneeRepository->findWithDepartments($id);

        if ($ticketAssignee === null) {
            return $this->respondNotFound([
                'message' => 'Staff not found.',
            ]);
        }

        return new TicketAssigneeResource($ticketAssignee);
    }
}
