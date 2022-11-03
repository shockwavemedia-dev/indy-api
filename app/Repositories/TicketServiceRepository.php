<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tickets\TicketService;
use App\Repositories\Interfaces\TicketServiceRepositoryInterface;

final class TicketServiceRepository extends BaseRepository implements TicketServiceRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new TicketService());
    }
}
