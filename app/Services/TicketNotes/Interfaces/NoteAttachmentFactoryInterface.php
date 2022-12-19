<?php

namespace App\Services\TicketNotes\Interfaces;

use App\Models\NoteAttachment;
use App\Services\TicketNotes\Resources\CreateNoteAttachmentResource;

interface NoteAttachmentFactoryInterface
{
    public function make(CreateNoteAttachmentResource $resource): NoteAttachment;
}
