<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Events;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Events\EventsResource;
use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListEventController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private EventRepositoryInterface $eventRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        EventRepositoryInterface $eventRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->eventRepository = $eventRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        if ($client->getId() !== $this->getUser()->getUserType()->getClient()->getId()) {
            return $this->respondForbidden();
        }

        $events = $this->eventRepository->findByClient($client);

        return new EventsResource($events);
    }
}
