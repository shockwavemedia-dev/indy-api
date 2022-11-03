<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketNotes;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\User;
use App\Repositories\Interfaces\TicketNoteRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class DeleteTicketNoteController extends AbstractAPIController
{
    private TicketNoteRepositoryInterface $ticketNoteRepository;

    public function __construct(TicketNoteRepositoryInterface $ticketNoteRepository,)
    {
        $this->ticketNoteRepository = $ticketNoteRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var \App\Models\Tickets\TicketNote $ticketNote */
        $ticketNote = $this->ticketNoteRepository->find($id);

        /** @var User $user */
        $user = $this->getUser();

        if ($ticketNote === null) {
            return $this->respondNoContent();
        }

        try {
            $this->ticketNoteRepository->deleteTicketNote($ticketNote,$user);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondNoContent();
        }
    }
}
