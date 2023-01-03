<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\ClientServices;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\ClientServices\ClientServicesResource;
use App\Models\Client;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\ClientServiceRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListClientServiceController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private ClientServiceRepositoryInterface $clientServiceRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        ClientServiceRepositoryInterface $clientServiceRepository,
    ) {
        $this->clientRepository = $clientRepository;
        $this->clientServiceRepository = $clientServiceRepository;
    }

    public function __invoke(PaginationRequest $request, int $id): JsonResource
    {
        try {
            /** @var Client $client */
            $client = $this->clientRepository->find($id);

            if ($client === null) {
                return $this->respondNotFound([
                    'message' => 'Client not found.',
                ]);
            }

            $isAdmin = false;

            if ($this->getUser()->getUserType() instanceof AdminUser === true) {
                $isAdmin = true;
            }

            $clientServices = $this->clientServiceRepository->getClientServices(
                $client,
                $request->getSize(),
                $request->getPageNumber()
            );

            return new ClientServicesResource($clientServices, $isAdmin);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
