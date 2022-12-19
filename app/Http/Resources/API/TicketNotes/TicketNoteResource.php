<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketNotes;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\NoteAttachment;
use App\Models\Tickets\TicketNote;

final class TicketNoteResource extends Resource
{
    /**
     * @return mixed[]
     *
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof TicketNote) === false) {
            throw new InvalidResourceTypeException(
                TicketNote::class
            );
        }

        /** @var TicketNote $ticketNote */
        $ticketNote = $this->resource;

        $ticketAttachments = [];

        /** @var NoteAttachment $attachment */
        foreach ($ticketNote->getAttachments() as $attachment) {
            $ticketAttachments[] = $attachment->getFile();
        }

        return [
            'id' => $ticketNote->getId(),
            'ticket_id' => $ticketNote->getTicketId(),
            'attachments' => $ticketAttachments,
            'note' => $ticketNote->getNote(),
            'file' => $ticketNote->getTicketFileVersion()?->getFile(),
            'ticket_file' => $ticketNote->getTicketFileVersion()?->getTicketFile(),
            'created_by' => $ticketNote->getCreatedBy()->getFullName(),
            'created_at' => $ticketNote->getCreatedAtAsString(),
        ];
    }
}
