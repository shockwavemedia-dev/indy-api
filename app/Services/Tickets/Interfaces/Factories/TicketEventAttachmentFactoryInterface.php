<?php

namespace App\Services\Tickets\Interfaces\Factories;

use App\Models\Tickets\TicketEventAttachment;
use App\Services\Tickets\Resources\CreateTicketEventAttachmentResource;

interface TicketEventAttachmentFactoryInterface
{
    public function make(CreateTicketEventAttachmentResource $resource): TicketEventAttachment;
}
