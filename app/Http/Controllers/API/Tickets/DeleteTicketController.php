<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\User;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class DeleteTicketController extends AbstractAPIController
{
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var \App\Models\Tickets\Ticket $ticket */
        $ticket = $this->ticketRepository->find($id);

        /** @var User $user */
        $user = $this->getUser();

        if ($ticket === null) {
            return $this->respondNoContent();
        }

        try {
            $this->ticketRepository->deleteTicketSupport($ticket, $user);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondNoContent();
        }
    }
}
