<?php

declare(strict_types=1);

namespace App\Services\TicketChats\Factories;

use App\Models\TicketChat;
use App\Repositories\Interfaces\TicketChatRepositoryInterface;
use App\Services\TicketChats\Interfaces\TicketChatFactoryInterface;
use App\Services\TicketChats\Resources\CreateTicketChatResource;

final class TicketChatFactory implements TicketChatFactoryInterface
{
    public function __construct(private TicketChatRepositoryInterface $ticketChatRepository)
    {
    }

    public function make(CreateTicketChatResource $resource): TicketChat
    {
        /** @var TicketChat $ticketChat */
        $ticketChat = $this->ticketChatRepository->create([
            'ticket_id' => $resource->getTicket()->getId(),
            'message' => $resource->getMessage(),
            'created_by' => $resource->getUser()->getId(),
        ]);

        return $ticketChat;
    }
}
