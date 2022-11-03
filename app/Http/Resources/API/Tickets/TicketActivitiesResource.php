<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Tickets;

use App\Http\Resources\Resource;

final class TicketActivitiesResource extends Resource
{
    protected function getResponse(): array
    {
        $ticketActivity = [];

        foreach ($this->resource as $activity) {
            $ticketActivity['data'][] = new TicketActivityResource($activity);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $ticketActivity['page'] = $this->paginationResource($this->resource);

        return $ticketActivity;
    }
}
