<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketChats;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\TicketChats\TicketChatsResource;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListTicketChatController extends AbstractAPIController
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository,
    ) {
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws Exception
     */
    public function __invoke(int $id): JsonResource
    {
        /** @var Ticket $ticket */
        $ticket = $this->ticketRepository->findWithChats($id);

        if ($ticket === null) {
            return $this->respondNotFound(['message' => 'Ticket not found']);
        }

        return new TicketChatsResource($ticket->getChats());
    }
}
