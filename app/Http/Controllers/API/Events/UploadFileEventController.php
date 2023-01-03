<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Events;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Events\UploadFileEventRequest;
use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Services\EventsService\Interfaces\FilesUploadResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class UploadFileEventController extends AbstractAPIController
{
    private EventRepositoryInterface $eventRepository;

    private FilesUploadResolverInterface $filesUploadResolver;

    public function __construct(
        EventRepositoryInterface $eventRepository,
        FilesUploadResolverInterface $filesUploadResolver
    ) {
        $this->eventRepository = $eventRepository;
        $this->filesUploadResolver = $filesUploadResolver;
    }

    public function __invoke(UploadFileEventRequest $request, int $id): JsonResource
    {
        /** @var Event $event */
        $event = $this->eventRepository->find($id);

        if ($event === null) {
            return $this->respondNotFound([
                'message' => 'Not found.',
            ]);
        }

        $user = $this->getUser();

        if ($event->getClient()->getId() !== $user->getUserType()->getClient()?->getId()) {
            return $this->respondForbidden();
        }

        $this->filesUploadResolver->resolve(
            $event,
            $user,
            $request->getFiles()
        );

        return $this->respondNoContent();
    }
}
