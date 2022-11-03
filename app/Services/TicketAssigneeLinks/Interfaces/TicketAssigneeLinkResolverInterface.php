<?php

namespace App\Services\TicketAssigneeLinks\Interfaces;

use App\Services\TicketAssigneeLinks\Resources\CreateTicketAssigneeLinkResource;

interface TicketAssigneeLinkResolverInterface
{
    public function resolve(CreateTicketAssigneeLinkResource $resource): void;
}
