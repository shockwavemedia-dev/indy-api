<?php

declare(strict_types=1);

namespace App\Services\ClientServices;

use App\Models\Client;
use App\Models\User;
use App\Repositories\Interfaces\ClientServiceRepositoryInterface;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\ClientServices\Interfaces\ClientServiceFactoryInterface;
use App\Services\ClientServices\Resources\CreateClientServiceResource;

final class ClientServiceFactory implements ClientServiceFactoryInterface
{
    private ClientServiceRepositoryInterface $clientServiceRepository;
    private ServiceRepositoryInterface $serviceRepository;

    public function __construct (
        ClientServiceRepositoryInterface $clientServiceRepository,
        ServiceRepositoryInterface $serviceRepository,
    ) {
        $this->clientServiceRepository = $clientServiceRepository;
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function make(Client $client, User $user): void
    {
        $services = $this->serviceRepository->all();

          foreach($services as $service) {
              $this->clientServiceRepository->createClientService(new CreateClientServiceResource([
                  'clientId' => $client->getId(),
                  'serviceId' => $service->getId(),
                  'extras' => $service->getExtras(),
                  'createdById' => $user->getId()
              ]));
          }
    }
}
