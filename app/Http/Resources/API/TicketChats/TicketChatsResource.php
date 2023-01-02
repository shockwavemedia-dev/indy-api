<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketChats;

use App\Http\Resources\Resource;

final class TicketChatsResource extends Resource
{
    protected function getResponse(): array
    {
        $ticketChats = $this->resource;

        $result = [];

        foreach ($ticketChats as $ticketChat) {
            $result['data'][] = new TicketChatResource($ticketChat);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        return $result;
    }
}
