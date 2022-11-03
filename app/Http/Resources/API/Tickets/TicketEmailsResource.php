<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Tickets;

use App\Http\Resources\Resource;

final class TicketEmailsResource extends Resource
{
    protected function getResponse(): array
    {
        $ticketEmails = [];

        foreach ($this->resource as $email) {
            $ticketEmails['data'][] = new TicketEmailResource($email);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $ticketEmails['page'] = $this->paginationResource($this->resource);

        return $ticketEmails;
    }
}
