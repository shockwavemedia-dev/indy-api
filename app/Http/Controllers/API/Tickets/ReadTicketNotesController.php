<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ReadTicketNotesController extends AbstractAPIController
{
    public function __construct(private TicketRepositoryInterface $ticketRepository)
    {
    }

    public function __invoke(int $id): JsonResource
    {
        $ticket = $this->ticketRepository->find($id);

        if ($ticket === null) {
            return $this->respondNotFound(['message' => 'Ticket not found']);
        }

        $this->ticketRepository->resetUserNotes($ticket, $this->getUser());

        return $this->respondNoContent();
    }
}
