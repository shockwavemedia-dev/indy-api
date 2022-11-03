<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets\Validations;

use App\Models\Client;
use App\Models\ClientService;
use App\Models\Service;
use App\Services\Tickets\Exceptions\ClientEmptyServicesException;
use App\Services\Tickets\Exceptions\InvalidServiceException;
use App\Services\Tickets\Validations\TicketEventServicesValidator;
use Illuminate\Database\Eloquent\Collection;
use Tests\Stubs\Repositories\ServiceRepositoryStub;
use Tests\Stubs\Services\Tickets\Validations\Rules\TicketEventServiceValidationRuleStub;
use Tests\TestCase;

/**
 * @covers \App\Services\Tickets\Validations\TicketEventServicesValidator
 */
final class TicketEventServicesValidatorTest extends TestCase
{
    /**
     * @throws \App\Services\Tickets\Exceptions\TicketEventServiceRuleException
     */
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

        $rule = new TicketEventServiceValidationRuleStub([
            'validate' => true,
        ]);

        $validator = new TicketEventServicesValidator($serviceRepository, [$rule]);

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

    /**
     * @throws \App\Services\Tickets\Exceptions\TicketEventServiceRuleException
     */
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

        $rule = new TicketEventServiceValidationRuleStub();

        $validator = new TicketEventServicesValidator($serviceRepository, [$rule]);


        $client = new Client();

        self::expectException(InvalidServiceException::class);
        $validator->validate($client, $services);
    }

    /**
     * @throws \App\Services\Tickets\Exceptions\TicketEventServiceRuleException
     */
    public function testValidateThrowClientEmptyServicesException(): void
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

        $rule = new TicketEventServiceValidationRuleStub([
            'validate' => true,
        ]);

        $validator = new TicketEventServicesValidator($serviceRepository, [$rule]);

        $client = new Client();

        $clientService1 = new ClientService();
        $clientService1->setAttribute('id', 1);
        $clientService1->setAttribute('service_id', 1);
        $clientService1->setRelation('service', $service1);
        $clientService1->setRelation('client', $client);

        $clientServicesCollection = new Collection();
        $clientServicesCollection->add($clientService1);

        $client->setRelation('clientServices', $clientServicesCollection);

        self::expectException(ClientEmptyServicesException::class);

        $validator->validate($client, $services);
    }

    /**
     * @throws \App\Services\Tickets\Exceptions\TicketEventServiceRuleException
     */
    public function testValidateThrowClientEmptyServicesExceptionBadData(): void
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

        $rule = new TicketEventServiceValidationRuleStub([
            'validate' => true,
        ]);

        $validator = new TicketEventServicesValidator($serviceRepository, [$rule]);

        $client = new Client();

        self::expectException(ClientEmptyServicesException::class);

        $validator->validate($client, $services);
    }
}
