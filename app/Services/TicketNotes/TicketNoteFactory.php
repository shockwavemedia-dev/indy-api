<?php

declare(strict_types=1);

namespace App\Services\TicketNotes;

use App\Models\Tickets\TicketNote;
use App\Repositories\Interfaces\TicketNoteRepositoryInterface;
use App\Services\TicketNotes\Resources\CreateTicketNoteResource;
use App\Services\TicketNotes\Interfaces\TicketNoteFactoryInterface;

final class TicketNoteFactory implements TicketNoteFactoryInterface
{
    private TicketNoteRepositoryInterface $ticketNoteRepository;

    public function __construct(TicketNoteRepositoryInterface $ticketNoteRepository)
    {
        $this->ticketNoteRepository = $ticketNoteRepository;
    }

    public function make(CreateTicketNoteResource $resource): TicketNote
    {
        /** @var TicketNote $ticketNote */
        $ticketNote = $this->ticketNoteRepository->create([
            'ticket_id' => $resource->getTicket()->getId(),
            'created_by' => $resource->getCreatedBy()->getId(),
            'note' => $resource->getNote()
        ]);

        return $ticketNote;
    }
}
