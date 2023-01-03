<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Events;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Events\UpdateEventRequest;
use App\Http\Resources\API\Events\EventResource;
use App\Models\Event;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Services\EventsService\Interfaces\EventFileFolderUpdateResolverInterface;
use App\Services\EventsService\Interfaces\EventUpdateResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdateEventController extends AbstractAPIController
{
    private AdminUserRepositoryInterface $adminUserRepository;

    private EventFileFolderUpdateResolverInterface $eventFileFolderUpdateResolver;

    private EventRepositoryInterface $eventRepository;

    private EventUpdateResolverInterface $eventUpdateResolver;

    public function __construct(
        AdminUserRepositoryInterface $adminUserRepository,
        EventFileFolderUpdateResolverInterface $eventFileFolderUpdateResolver,
        EventRepositoryInterface $eventRepository,
        EventUpdateResolverInterface $eventUpdateResolver
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->eventFileFolderUpdateResolver = $eventFileFolderUpdateResolver;
        $this->eventRepository = $eventRepository;
        $this->eventUpdateResolver = $eventUpdateResolver;
    }

    public function __invoke(UpdateEventRequest $request, int $id): JsonResource
    {
        /** @var Event $event */
        $event = $this->eventRepository->find($id);

        if ($event === null) {
            return $this->respondNotFound([
                'message' => 'Not found.',
            ]);
        }

        $data = $request->all();

        if ($event->getClient()->getId() !== $this->getUser()->getUserType()->getClient()->getId()) {
            return $this->respondForbidden();
        }

        $event = $this->eventUpdateResolver->resolve(
            $event,
            $this->getUser(),
            $data,
        );

        $this->eventFileFolderUpdateResolver->resolve($event);

        return new EventResource($event);
    }
}
