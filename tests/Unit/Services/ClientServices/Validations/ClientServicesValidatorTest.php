<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ClientServices\Validations;

use App\Models\Client;
use App\Models\ClientService;
use App\Models\Service;
use App\Services\ClientServices\Validations\ClientServicesValidator;
use App\Services\Tickets\Exceptions\InvalidServiceException;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\ServiceRepositoryStub;
use Tests\Stubs\Services\ClientServices\Validations\Rules\ClientServiceValidationRuleStub;

/**
 * @covers \App\Services\ClientServices\Validations\ClientServicesValidator
 */
final class ClientServicesValidatorTest extends TestCase
{
    public function testValidateSuccess(): void
    {
        $services = [
            [
                'service_id' => 1,
            ],
            [
                'service_id' => 2,
            ],
        ];

        $service1 = new Service();
        $service1->setAttribute('id', 1);
        $service2 = new Service();
        $service2->setAttribute('id', 2);

        $serviceCollection = new Collection();
        $serviceCollection->add($service1);
        $serviceCollection->add($service2);

        $serviceRepository = new ServiceRepositoryStub([
            'findByIds' => $serviceCollection,
        ]);

        $rule = new ClientServiceValidationRuleStub([
            'validate' => true,
        ]);

        $validator = new ClientServicesValidator($serviceRepository, [$rule]);

        $client = new Client();

        $clientService1 = new ClientService();
        $clientService1->setAttribute('id', 1);
        $clientService1->setAttribute('service_id', 1);
        $clientService1->setRelation('service', $service1);
        $clientService1->setRelation('client', $client);

        $clientService2 = new ClientService();
        $clientService2->setAttribute('id', 2);
        $clientService2->setAttribute('service_id', 2);
        $clientService2->setRelation('service', $service2);
        $clientService2->setRelation('client', $client);

        $clientServicesCollection = new Collection();
        $clientServicesCollection->add($clientService1);
        $clientServicesCollection->add($clientService2);

        $client->setRelation('clientServices', $clientServicesCollection);

        $result = $validator->validate($client, $services);

        self::assertTrue($result);
    }

    public function testValidateThrowInvalidServiceException(): void
    {
        $services = [
            [
                'service_id' => 1,
            ],
            [
                'service_id' => 2,
            ],
        ];

        $service1 = new Service();
        $service1->setAttribute('id', 1);

        $serviceCollection = new Collection();
        $serviceCollection->add($service1);

        $serviceRepository = new ServiceRepositoryStub([
            'findByIds' => $serviceCollection,
        ]);

        $rule = new ClientServiceValidationRuleStub();

        $validator = new ClientServicesValidator($serviceRepository, [$rule]);

        $client = new Client();

        self::expectException(InvalidServiceException::class);
        $validator->validate($client, $services);
    }
}
