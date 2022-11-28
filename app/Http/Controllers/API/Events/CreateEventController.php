<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Events;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Events\CreateEventRequest;
use App\Http\Resources\API\Events\EventResource;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\EventsService\Interfaces\EventFactoryInterface;
use App\Services\EventsService\Interfaces\EventFolderFactoryInterface;
use App\Services\EventsService\Resources\CreateEventResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

final class CreateEventController extends AbstractAPIController
{
    private AdminUserRepositoryInterface $adminUserRepository;

    private ClientRepositoryInterface $clientRepository;

    private EventFactoryInterface $eventFactory;

    private EventFolderFactoryInterface $eventFolderFactory;

    public function __construct(
        AdminUserRepositoryInterface $adminUserRepository,
        ClientRepositoryInterface $clientRepository,
        EventFactoryInterface $eventFactory,
        EventFolderFactoryInterface $eventFolderFactory
    ) {
        $this->adminUserRepository = $adminUserRepository;
        $this->clientRepository = $clientRepository;
        $this->eventFactory = $eventFactory;
        $this->eventFolderFactory = $eventFolderFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(CreateEventRequest $request, int $id): JsonResource
    {
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        if ($client->getId() !== $this->getUser()->getUserType()->getClient()->getId()) {
            return $this->respondForbidden();
        }

        $resources = [];

        foreach ($request->all() as $key => $param) {
            $resources[Str::camel($key)] = $param;
        }

        if ($resources['stylingRequired'] !== null) {
            $resources['stylingRequired'] = $resources['stylingRequired'] ?? 'No' === 'Yes';
        }

        if ($request->get('photographer_id') !== null) {
            $resources['photographer'] = $this->adminUserRepository->find($request->get('photographer_id'));
        }

        $resources['createdBy'] = $this->getUser();
        $resources['client'] = $client;

        $event = $this->eventFactory->make(new CreateEventResource(
            $resources
        ));

        $this->eventFolderFactory->make($event);

        return new EventResource($event);
    }
}
