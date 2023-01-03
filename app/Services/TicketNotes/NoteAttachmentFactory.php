<?php

declare(strict_types=1);

namespace App\Services\TicketNotes;

use App\Models\NoteAttachment;
use App\Services\TicketNotes\Interfaces\NoteAttachmentFactoryInterface;
use App\Services\TicketNotes\Resources\CreateNoteAttachmentResource;

final class NoteAttachmentFactory implements NoteAttachmentFactoryInterface
{
    public function make(CreateNoteAttachmentResource $resource): NoteAttachment
    {
        return NoteAttachment::create([
            'ticket_note_id' => $resource->getTicketNote()->getId(),
            'file_id' => $resource->getFile()->getId(),
            'created_by' => $resource->getCreatedBy()->getId(),
        ]);
    }
}
