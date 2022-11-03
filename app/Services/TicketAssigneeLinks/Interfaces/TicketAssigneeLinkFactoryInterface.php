<?php

namespace App\Services\TicketAssigneeLinks\Interfaces;

use App\Models\Tickets\TicketAssigneeLink;
use App\Services\TicketAssigneeLinks\Resources\CreateTicketAssigneeLinkResource;

interface TicketAssigneeLinkFactoryInterface
{
    public function make(CreateTicketAssigneeLinkResource $resource): TicketAssigneeLink;
}
