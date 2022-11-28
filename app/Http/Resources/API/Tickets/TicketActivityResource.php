<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Tickets;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Tickets\TicketActivity;
use function sprintf;

final class TicketActivityResource extends Resource
{
    /**
     * @return mixed[]
     *
     * @throws \App\Exceptions\InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof TicketActivity) === false) {
            throw new InvalidResourceTypeException(
                TicketActivity::class
            );
        }

        /** @var \App\Models\Tickets\TicketActivity $ticketActivity */
        $ticketActivity = $this->resource;

        return [
            'id' => $ticketActivity->getId(),
            'ticket_id' => $ticketActivity->getTicketId(),
            'activity' => $ticketActivity->getActivity(),
            'user' => sprintf(
                '%s %s %s',
                $ticketActivity->getUser()->getFirstName(),
                $ticketActivity->getUser()->getMiddleName(),
                $ticketActivity->getUser()->getLastName(),
            ),
            'created_at' => $ticketActivity->getCreatedAtAsString(),
        ];
    }
}
