<?php

declare(strict_types=1);

namespace App\Services\ClientTicketFiles;

use App\Models\Tickets\ClientTicketFile;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Services\ClientTicketFiles\Interfaces\TicketFileFactoryInterface;
use App\Services\ClientTicketFiles\Resources\CreateClientTicketFileResource;

final class TicketFileFactory implements TicketFileFactoryInterface
{
    private ClientTicketFileRepositoryInterface $clientTicketFileRepository;

    public function __construct(ClientTicketFileRepositoryInterface $clientTicketFileRepository)
    {
        $this->clientTicketFileRepository = $clientTicketFileRepository;
    }

    public function make(CreateClientTicketFileResource $resource): ClientTicketFile
    {
        $ticket = $resource->getTicket();

        /** @var \App\Models\Tickets\ClientTicketFile $clientTicketFile */
        $clientTicketFile = $this->clientTicketFileRepository->create([
            'file_id' => $resource->getFile()->getId(),
            'client_id' => $ticket->getClient()->getId(),
            'ticket_id' => $ticket->getId(),
            'status' => $resource->getStatusEnum(),
            'description' => $resource->getDescription(),
            'admin_user_id' => $resource->getAssignedStaff()->getId(),
            'approved_by' => $resource->getApprovedBy(),
            'approved_at' => $resource->getApprovedAt(),
        ]);

        return $clientTicketFile;
    }
}
