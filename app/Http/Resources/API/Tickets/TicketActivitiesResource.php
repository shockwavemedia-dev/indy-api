<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Tickets;

use App\Http\Resources\Resource;
use App\Models\Tickets\TicketActivity;

final class TicketActivitiesResource extends Resource
{
    protected function getResponse(): array
    {
        $ticketActivities = [];

        /** @var ?TicketActivity $singleActivity */
        $singleActivity = null;

        foreach ($this->resource as $activity) {
            $ticketActivities['data'][] = new TicketActivityResource($activity);

            if ($singleActivity !== null) {
                continue;
            }

            $singleActivity = $activity;
        }

        $initialActivity = [
            'id' => 0,
            'ticket_id' => 0,
            'activity' => \sprintf('Ticket Submitted by: %s', $singleActivity?->getTicket()->getCreatedBy()->getFullName()),
            'user' => $singleActivity?->getTicket()->getCreatedBy()->getFullName(),
            'created_at' => $singleActivity?->getTicket()->getCreatedAtAsString(),
        ];

        $ticketActivities['data'][] = $initialActivity;

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $ticketActivities['page'] = $this->paginationResource($this->resource);

        return $ticketActivities;
    }
}
