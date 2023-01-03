<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\TicketChat;
use App\Repositories\Interfaces\TicketChatRepositoryInterface;

final class TicketChatRepository extends BaseRepository implements TicketChatRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new TicketChat());
    }
}
