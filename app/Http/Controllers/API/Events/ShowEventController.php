<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Events;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Events\EventResource;
use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;

final class ShowEventController extends AbstractAPIController
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function __invoke(int $id)
    {
        /** @var Event $event */
        $event = $this->eventRepository->find($id);

        if ($event === null) {
            return $this->respondNotFound([
                'message' => 'Not found.',
            ]);
        }

        if ($event->getClient()->getId() !== $this->getUser()->getUserType()->getClient()->getId()) {
            return $this->respondForbidden();
        }

        return new EventResource($event);
    }
}
