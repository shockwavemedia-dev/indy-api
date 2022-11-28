<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ClientServices;

use App\Enum\ServiceExtraEnum;
use App\Enum\ServicesEnum;
use App\Models\Client;
use App\Models\ClientService;
use App\Models\Service;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Services\ClientServices\ClientServiceFactory;
use App\Services\ClientServices\Resources\CreateClientServiceResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\ClientServiceRepositoryStub;
use Tests\Stubs\Repositories\ServiceRepositoryStub;

/**
 * @covers \App\Services\ClientServices\ClientServiceFactory
 */
final class ClientServiceFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testCreateClientServicesSuccess(): void
    {
        $adminUser = new AdminUser();
        $user = new User();
        $user->setRelation('userType', $adminUser);
        $user->setAttribute('id', 1);

        $client = new Client();
        $client->setAttribute('client_code', 'test');
        $client->setAttribute('id', 1);

        $service1 = new Service();
        $service1->setAttribute('id', 1);
        $service1->setAttribute('extras', Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::GRAPHIC_DESIGN, []));

        $service2 = new Service();
        $service2->setAttribute('id', 2);
        $service2->setAttribute('extras', Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::ADVERTISING, []));

        $serviceCollection = new Collection();
        $serviceCollection->add($service1);
        $serviceCollection->add($service2);

        $clientService1 = new ClientService();
        $clientService1->setAttribute('service_id', 1);

        $clientService2 = new ClientService();
        $clientService2->setAttribute('service_id', 2);

        $paginator = new LengthAwarePaginator($serviceCollection, 2, 2);

        $serviceRepository = new ServiceRepositoryStub([
            'all' => $paginator,
        ]);

        $clientServiceRepository = new ClientServiceRepositoryStub([
            'createClientService' => $clientService1,
            'createClientService' => $clientService2,
        ]);

        $resolver = new ClientServiceFactory(
            $clientServiceRepository,
            $serviceRepository
        );

        $expectedCall = [
            [
                'createClientService' => [
                    new CreateClientServiceResource([
                        'clientId' => 1,
                        'serviceId' => 1,
                        'extras' => Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::GRAPHIC_DESIGN, []),
                        'createdById' => 1,
                    ]),
                ],
            ],
            [
                'createClientService' => [
                    new CreateClientServiceResource([
                        'clientId' => 1,
                        'serviceId' => 2,
                        'extras' => Arr::get(ServiceExtraEnum::EXTRAS, ServicesEnum::ADVERTISING, []),
                        'createdById' => 1,
                    ]),
                ],
            ],
        ];

        $resolver->make($client, $user);

        $this->assertEquals($expectedCall, $clientServiceRepository->getCalls());
    }
}
