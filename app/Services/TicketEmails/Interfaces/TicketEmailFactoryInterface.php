<?php

namespace App\Services\TicketEmails\Interfaces;

use App\Models\Tickets\TicketEmail;
use App\Services\TicketEmails\Resources\CreateTicketEmailResource;

interface TicketEmailFactoryInterface
{
    public function make(CreateTicketEmailResource $resource): TicketEmail;
}
