<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Tickets;

use App\Http\Resources\Resource;
use App\Models\Tickets\Ticket;

final class TicketSupportsResource extends Resource
{
    private ?bool $showOverdue;

    public function __construct($resource, ?bool $showOverdue = false)
    {
        $this->showOverdue = $showOverdue;
        parent::__construct($resource);
    }

    protected function getResponse(): array
    {
        $tickets = [];

        /** @var Ticket $ticket */
        foreach ($this->resource as $ticket) {
            if ($this->showOverdue === true && $ticket->isOverdue() === false) {
                continue;
            }

            $tickets['data'][] = new TicketSupportResource($ticket);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $tickets['page'] = $this->paginationResource($this->resource);

        return $tickets;
    }
}
