<?php

namespace App\Services\TicketNotes\Interfaces;

use App\Models\Tickets\TicketNote;
use App\Services\TicketNotes\Resources\CreateTicketNoteResource;

interface TicketNoteFactoryInterface
{
    public function make(CreateTicketnoteResource $resource): TicketNote;
}
