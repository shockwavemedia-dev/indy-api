<?php

declare(strict_types=1);

namespace App\Services\Libraries\Interfaces\Factories;

use App\Models\Tickets\Ticket;
use App\Services\Libraries\Resources\CreateLibraryTicketEventResource;

interface LibraryTicketEventFactoryInterface
{
    public function make(CreateLibraryTicketEventResource $resource): Ticket;
}
