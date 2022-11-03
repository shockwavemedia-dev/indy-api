<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Enum\TicketStatusEnum;
use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Tickets\TicketSupportResource;
use App\Models\User;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowTicketController extends AbstractAPIController
{
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var \App\Models\Tickets\Ticket $ticket */
        $ticket = $this->ticketRepository->find($id);

        if ($ticket === null) {
            return $this->respondNotFound([
                'message' => 'Ticket not found.',
            ]);
        }

        if ($ticket->getStatus()->getValue() === TicketStatusEnum::NEW) {
            $this->ticketRepository->updateStatusToOpen($ticket);
        }

        $userClientId = null;

        if ($user->getUserType()->getType()->getValue() === UserTypeEnum::CLIENT) {
            $userClientId = $user->getUserType()->getClientId();
        }

        if ($userClientId === null || $userClientId === $ticket->getClientId()) {
            return new TicketSupportResource($ticket);
        }

        return $this->respondForbidden(['message' => 'You do not have access to this.']);
    }
}
