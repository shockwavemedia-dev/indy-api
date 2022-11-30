<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\Client;
use App\Models\User;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\NotificationUserRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;

final class ClientTicketAndNotificationCountsController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private NotificationUserRepositoryInterface $notificationUserRepository;

    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        NotificationUserRepositoryInterface $notificationUserRepository,
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->notificationUserRepository = $notificationUserRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(int $id)
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        /** @var User $user */
        $user = $this->getUser();

        return response()->json([
            'new_ticket_count' => $this->ticketRepository->countNewTicketByClient($client),
            'open_ticket_count' => $this->ticketRepository->countOpenTicketByClient($client),
            'new_notification_count' => $this->notificationUserRepository->countNewNotificationByUser(
                $user
            ),
        ]);
    }
}
