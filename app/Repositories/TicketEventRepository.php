<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\File;
use App\Models\Tickets\TicketEvent;
use App\Repositories\Interfaces\TicketEventRepositoryInterface;

final class TicketEventRepository extends BaseRepository implements TicketEventRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new TicketEvent());
    }

    public function updateTicketAttachment(File $file, TicketEvent $ticketEvent): TicketEvent
    {
        $ticketEvent->attachmentFiles()->save($file);

        return $ticketEvent;
    }
}
