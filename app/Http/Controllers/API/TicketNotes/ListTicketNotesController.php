<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketNotes;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\TicketNotes\TicketNotesResource;
use App\Repositories\Interfaces\TicketNoteRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListTicketNotesController extends AbstractAPIController
{
    private TicketRepositoryInterface $ticketRepository;

    private TicketNoteRepositoryInterface $ticketNoteRepository;

    public function __construct(
        TicketRepositoryInterface $ticketRepository,
        TicketNoteRepositoryInterface $ticketNoteRepository,
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->ticketNoteRepository = $ticketNoteRepository;
    }

    public function __invoke(PaginationRequest $request, int $id): JsonResource
    {
        /** @var \App\Models\Tickets\Ticket $ticket */
        $ticket = $this->ticketRepository->find($id);

        if ($ticket === null) {
            return $this->respondNotFound([
                'message' => 'Ticket not found.',
            ]);
        }

        try {
            $notes = $this->ticketNoteRepository->findAllTicketNotes($ticket, $request->getSize(), $request->getPageNumber());

            return new TicketNotesResource($notes);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
