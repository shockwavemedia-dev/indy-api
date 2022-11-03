<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketNotes;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Tickets\TicketNote;
use function sprintf;

final class TicketNoteResource extends Resource
{
    /**
     * @return mixed[]
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

        return [
            'id' => $ticketNote->getId(),
            'ticket_id' => $ticketNote->getTicketId(),
            'note' => $ticketNote->getNote(),
            'created_by' => sprintf(
                '%s %s %s',
                $ticketNote->getCreatedBy()->getFirstName(),
                $ticketNote->getCreatedBy()->getMiddleName(),
                $ticketNote->getCreatedBy()->getLastName(),
            ),
            'created_at' => $ticketNote->getCreatedAtAsString(),
        ];
    }
}
