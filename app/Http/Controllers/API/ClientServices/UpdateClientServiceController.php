<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\ClientServices;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\ClientServices\UpdateClientServiceRequest;
use App\Http\Resources\API\ClientServices\ClientServicesResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\ClientServiceRepositoryInterface;
use App\Services\ClientServices\Interfaces\ClientServiceUpdateInterface;
use App\Services\ClientServices\Interfaces\Validations\ClientServicesValidatorInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

final class UpdateClientServiceController extends AbstractAPIController
{
    private ClientRepositoryInterface $clientRepository;

    private ClientServiceRepositoryInterface $clientServiceRepository;

    private ClientServiceUpdateInterface $clientServiceUpdate;

    private ClientServicesValidatorInterface $clientServiceValidator;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        ClientServiceRepositoryInterface $clientServiceRepository,
        ClientServiceUpdateInterface $clientServiceUpdate,
        ClientServicesValidatorInterface $clientServiceValidator
    ) {
        $this->clientRepository = $clientRepository;
        $this->clientServiceRepository = $clientServiceRepository;
        $this->clientServiceUpdate = $clientServiceUpdate;
        $this->clientServiceValidator = $clientServiceValidator;
    }

    public function __invoke(UpdateClientServiceRequest $request, int $id): JsonResource
    {
        /** @var \App\Models\Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        try {
            //update client services
            /** @var \App\Models\User $user */
            $user = $this->getUser();

            $this->clientServiceValidator->validate($client, $request->getClientServices());

            $this->clientServiceUpdate->update($client,$user,$request->getClientServices());

            $clientServices = $this->clientServiceRepository->getClientServices($client);

            return new ClientServicesResource($clientServices);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
