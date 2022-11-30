<?php

namespace App\Services\Tickets\Factories;

use App\Models\Tickets\TicketEventAttachment;
use App\Repositories\Interfaces\TicketEventAttachmentRepositoryInterface;
use App\Services\Tickets\Interfaces\Factories\TicketEventAttachmentFactoryInterface;
use App\Services\Tickets\Resources\CreateTicketEventAttachmentResource;

final class TicketEventAttachmentFactory implements TicketEventAttachmentFactoryInterface
{
    private TicketEventAttachmentRepositoryInterface $eventAttachmentRepository;

    public function __construct(TicketEventAttachmentRepositoryInterface $eventAttachmentRepository)
    {
        $this->eventAttachmentRepository = $eventAttachmentRepository;
    }

    public function make(CreateTicketEventAttachmentResource $resource): TicketEventAttachment
    {
        return $this->eventAttachmentRepository->create([
            'file_id' => $resource->getFile()->getId(),
            'ticket_event_id' => $resource->getTicketEvent()->getId(),
        ]);
    }
}
