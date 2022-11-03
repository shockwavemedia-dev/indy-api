<?php

declare(strict_types=1);

namespace App\Services\ClientTicketFiles\Interfaces;

use App\Models\Tickets\ClientTicketFile;
use App\Services\ClientTicketFiles\Resources\CreateClientTicketFileResource;

interface TicketFileFactoryInterface
{
    public function make(CreateClientTicketFileResource $resource): ClientTicketFile;
}
