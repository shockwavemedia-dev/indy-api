<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\File;
use App\Models\Tickets\TicketEvent;

interface TicketEventRepositoryInterface
{
    public function updateTicketAttachment(File $file, TicketEvent $ticketEvent): TicketEvent;
}
