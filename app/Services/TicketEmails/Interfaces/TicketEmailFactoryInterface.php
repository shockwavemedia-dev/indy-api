<?php

namespace App\Services\TicketEmails\Interfaces;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketEmail;
use App\Models\User;
use App\Services\TicketEmails\Resources\CreateTicketEmailResource;
use Illuminate\Database\Eloquent\Collection;

interface TicketEmailFactoryInterface
{
    public function make(CreateTicketEmailResource $resource): TicketEmail;
}
