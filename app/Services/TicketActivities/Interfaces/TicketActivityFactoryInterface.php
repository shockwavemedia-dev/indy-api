<?php

namespace App\Services\TicketActivities\Interfaces;

use App\Models\Tickets\TicketActivity;
use App\Services\TicketActivities\Resources\CreateTicketActivityResource;

interface TicketActivityFactoryInterface
{
    public function make(CreateTicketActivityResource $resource): TicketActivity;
}
