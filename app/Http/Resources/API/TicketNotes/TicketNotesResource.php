<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketNotes;

use App\Http\Resources\Resource;

final class TicketNotesResource extends Resource
{
    protected function getResponse(): array
    {
        $ticketNote = [];

        foreach ($this->resource as $note) {
            $ticketNote['data'][] = new TicketNoteResource($note);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $ticketNote['page'] = $this->paginationResource($this->resource);

        return $ticketNote;
    }
}
