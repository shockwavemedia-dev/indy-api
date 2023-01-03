<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Clients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class DeleteClientController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var \App\Models\Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNoContent();
        }

        try {
            $this->clientRepository->deleteClient($client);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondNoContent();
        }
    }
}
