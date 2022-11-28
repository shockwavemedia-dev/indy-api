<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enum\ServiceExtraEnum;
use App\Enum\ServicesEnum;
use App\Models\Client;
use App\Models\Service;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\ClientServiceRepositoryInterface;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\ClientServices\Resources\CreateClientServiceResource;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

final class ServicesSeeder extends Seeder
{
    private ClientRepositoryInterface $clientRepository;

    private ClientServiceRepositoryInterface $clientServiceRepository;

    private ServiceRepositoryInterface $serviceRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        ClientServiceRepositoryInterface $clientServiceRepository,
        ServiceRepositoryInterface $serviceRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->clientServiceRepository = $clientServiceRepository;
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function run(): void
    {
        $services = $this->serviceRepository->findByNames(ServicesEnum::toArray());

        $clients = $this->clientRepository->findAll();

        foreach (ServicesEnum::toArray() as $service) {
            /** @var \App\Models\Service $exist */
            $exist = $services->firstWhere('name', $service);

            if ($exist === null) {
                Service::firstOrCreate([
                    'extras' => Arr::get(ServiceExtraEnum::EXTRAS, $service),
                    'name' => $service,
                ]);

                continue;
            }

            $exist->updateExtras(Arr::get(ServiceExtraEnum::EXTRAS, $service) ?? []);

            $this->clientServiceRepository->updateClientsExtrasByService($exist);

            $exist->refresh();

            /** @var Client $client */
            foreach ($clients as $client) {
                $clientService = $client->getClientServiceByService($exist);

                if ($clientService !== null) {
                    continue;
                }

                $this->clientServiceRepository->createClientService(new CreateClientServiceResource([
                    'clientId' => $client->getId(),
                    'serviceId' => $exist->getId(),
                    'extras' => $exist->getExtras(),
                    'createdById' => 1,
                ]));
            }
        }
    }
}
