<?php

namespace App\Services\TicketChats\Interfaces;

use App\Models\TicketChat;
use App\Services\TicketChats\Resources\CreateTicketChatResource;

interface TicketChatFactoryInterface
{
    public function make(CreateTicketChatResource $resource): TicketChat;
}
