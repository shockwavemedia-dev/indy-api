<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\TicketAssignee\TicketAssigneesResource;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class TicketAssigneeListController extends AbstractAPIController
{
    private TicketAssigneeRepositoryInterface $ticketAssigneeRepository;

    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        TicketRepositoryInterface $ticketRepository,
        TicketAssigneeRepositoryInterface $ticketAssigneeRepository
    ) {
        $this->ticketAssigneeRepository = $ticketAssigneeRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var \App\Models\Tickets\Ticket $ticket */
        $ticket = $this->ticketRepository->find($id);

        if ($ticket === null) {
            return $this->respondNotFound([
                'message' => 'Ticket not found.',
            ]);
        }

        return new TicketAssigneesResource($this->ticketAssigneeRepository->findByTicket($ticket));
    }
}
