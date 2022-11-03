<?php

declare(strict_types=1);

namespace App\Services\ClientServices;

use App\Models\Client;
use App\Models\User;
use App\Repositories\Interfaces\ClientServiceRepositoryInterface;
use App\Services\ClientServices\Interfaces\ClientServiceUpdateInterface;
use App\Services\ClientServices\Resources\UpdateClientServiceResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

final class ClientServiceUpdate implements ClientServiceUpdateInterface
{
    private ClientServiceRepositoryInterface $clientServiceRepository;

    public function __construct
    (
        ClientServiceRepositoryInterface $clientServiceRepository
    )
    {
        $this->clientServiceRepository = $clientServiceRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function update(Client $client, User $user, array $services): Collection
    {
        /** @var \App\Models\ClientService $clientService */
        $clientServices = $client->getClientServices();

        $clientServicesCollection = new Collection();

          foreach($services as $service) {
              $clientService = $clientServices->where('service_id', '=' ,Arr::get($service, 'service_id'))->first();

              $clientService = $this->clientServiceRepository->updateClientService($clientService, new UpdateClientServiceResource([
                  'serviceId' => $service['service_id'],
                  'extras' => $service['extras'],
                  'updatedBy' => $user->getId(),
                  'marketingQuota' => $service['marketing_quota'],
                  'isEnabled' => $service['is_enabled'],
                  'extraQuota' => $service['extra_quota']
              ]));

              $clientServicesCollection->add($clientService);
          }

          return $clientServicesCollection;
    }
}
