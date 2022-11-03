<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tickets\TicketEventAttachment;
use App\Repositories\Interfaces\TicketEventAttachmentRepositoryInterface;

final class TicketEventAttachmentRepository extends BaseRepository implements TicketEventAttachmentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new TicketEventAttachment());
    }
}
