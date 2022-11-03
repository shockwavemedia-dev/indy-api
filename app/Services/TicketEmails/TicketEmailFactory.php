<?php

declare(strict_types=1);

namespace App\Services\TicketEmails;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketEmail;
use App\Models\User;
use App\Repositories\Interfaces\TicketEmailRepositoryInterface;
use App\Services\TicketEmails\Interfaces\TicketEmailFactoryInterface;
use App\Services\TicketEmails\Resources\CreateTicketEmailResource;
use Illuminate\Database\Eloquent\Collection;

final class TicketEmailFactory implements TicketEmailFactoryInterface
{
    private TicketEmailRepositoryInterface $ticketEmailRepository;

    public function __construct(
        TicketEmailRepositoryInterface $ticketEmailRepository,
    ) {
        $this->ticketEmailRepository = $ticketEmailRepository;
    }

    public function make(CreateTicketEmailResource $resource): TicketEmail
    {
        /** @var TicketEmail $email */
        $email = $this->ticketEmailRepository->create([
            'client_id' => $resource->getClientId(),
            'ticket_id' => $resource->getTicketId(),
            'sender_by' => $resource->getSenderBy(),
            'sender_type' => $resource->getSenderType(),
            'cc' => $resource->getCc(),
            'message' => $resource->getMessage(),
            'status' => $resource->getStatus(),
            'title' => $resource->getTitle(),
        ]);

        return $email;
    }
}
