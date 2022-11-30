<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Clients\MarkUserAsOwnerRequest;
use App\Http\Resources\API\Clients\ClientResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\ClientUserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class MarkUserAsOwnerController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private ClientUserRepositoryInterface $clientUserRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        ClientUserRepositoryInterface $clientUserRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->clientUserRepository = $clientUserRepository;
    }

    public function __invoke(MarkUserAsOwnerRequest $request, int $id): JsonResource
    {
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        if ($client->getOwnerId() === $request->getClientUserId()) {
            return new ClientResource($client);
        }

        $clientUser = $this->clientUserRepository->find($request->getClientUserId());

        if ($client->getId() !== $clientUser->getClientId()) {
            return $this->respondForbidden([
                'message' => 'User access is denied',
            ]);
        }

        try {
            $client = $this->clientRepository->updateClientOwner($client, $clientUser);

            return new ClientResource($client);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
