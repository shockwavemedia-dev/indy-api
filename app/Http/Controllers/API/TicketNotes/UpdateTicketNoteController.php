<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketNotes;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\TicketNotes\UpdateTicketNoteRequest;
use App\Http\Resources\API\TicketNotes\TicketNoteResource;
use App\Repositories\Interfaces\TicketNoteRepositoryInterface;
use App\Services\TicketNotes\Resources\UpdateTicketNoteResource;
use App\Services\Tickets\Exceptions\InvalidDueDateException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UpdateTicketNoteController extends AbstractAPIController
{
    private TicketNoteRepositoryInterface $ticketNoteRepository;

    public function __construct(
        TicketNoteRepositoryInterface $ticketNoteRepository
    ) {
        $this->ticketNoteRepository = $ticketNoteRepository;
    }

    public function __invoke(UpdateTicketNoteRequest $request, int $id): JsonResource
    {
        /** @var \App\Models\Tickets\TicketNote $ticketNote */
        $ticketNote = $this->ticketNoteRepository->find($id);

        if ($ticketNote === null) {
            return $this->respondNotFound([
                'message' => 'Ticket note not found.',
            ]);
        }

        try {
            if ($ticketNote->getNote() === $request->getNote()) {
                return new TicketNoteResource($ticketNote);
            }

            $ticketNote = $this->ticketNoteRepository->updateTicketNote($ticketNote, new UpdateTicketNoteResource([
                'note' => $request->getNote() ?? $ticketNote->getNote(),
                'updatedBy' => $this->getUser(),
            ]));

            return new TicketNoteResource($ticketNote);
        } catch (InvalidDueDateException $dueDateException) {
            return $this->respondBadRequest([
                'message' => $dueDateException->getMessage(),
            ]);
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
