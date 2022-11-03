<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Repositories\ClientServiceRepository;
use App\Services\ClientServices\Resources\CreateClientServiceResource;
use App\Services\ClientServices\Resources\UpdateClientServiceResource;
use Tests\TestCase;

/**
 * @covers \App\Repositories\ClientServiceRepository
 */
final class ClientServiceRepositoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testCreateClientService(): void
    {
        $user = $this->env->user()->user;

        $client = $this->env->client()->client;

        $service = $this->env->service()->service;

        $repository = new ClientServiceRepository();

        $createResource = new CreateClientServiceResource([
            'clientId' => $client->getId(),
            'serviceId' => $service->getId(),
            'extras' => $service->getextras(),
            'createdById' => $user->getId()
        ]);

        $clientServices = $repository->createClientService($createResource);

        $actual = [
            'client_id' => $clientServices->getClientId(),
            'service_id' => $clientServices->getServiceId(),
            'extras' => $clientServices->getExtras(),
            'created_by' => $clientServices->getCreatedById()
        ];

        $expected = [
            'client_id' => $client->getId(),
            'service_id' => $service->getId(),
            'extras' => $service->getextras(),
            'created_by' => $user->getId()
        ];

        $this->assertEquals($actual, $expected);
    }

    public function testIncreaseTotalUsageByClientService(): void
    {
        $clientService = $this->env->clientService()->clientService;

        $expected = $clientService->getTotalUsed() + 1;

        $repository = new ClientServiceRepository();

        $repository->increaseTotalUsageByClientService($clientService);

        $clientService->refresh();

        $this->assertEquals($expected, $clientService->getTotalUsed());
    }

    public function testGetClientServices(): void
    {
        $client = $this->env->client()->client;

        $clientService = $this->env->clientService(['client_id' => $client->getId()])->clientService;

        $repository = new ClientServiceRepository();

        $results = $repository->getClientServices($client);

        /** @var \App\Models\ClientService $actual */
        $actual = $results->find($clientService->getId());

        $this->assertEquals($client->getId(), $actual->getClientId());

        $this->assertArrayHasKeys(
            [
                'client_id',
                'service_id',
                'extras',
                'marketing_quota',
                'extra_quota',
                'total_used',
                'is_enabled'
            ],
            $actual->toArray()
        );
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testUpdateClientService(): void
    {
        $clientService = $this->env->clientService()->clientService;

        $updateResource = new UpdateClientServiceResource([
            'serviceId' => 1,
            'extras' => ["Facebook Event", "Facebook Post", "Instagram", "Twitter"],
            'updatedBy' => 1,
            'marketingQuota' => 0,
            'isEnabled' => true,
            'extraQuota' => 0
        ]);

        $repository = new ClientServiceRepository();

        $expected = [
            'serviceId' => 1,
            'extras' => ["Facebook Event", "Facebook Post", "Instagram", "Twitter"],
            'updatedBy' => 1,
            'marketingQuota' => 0,
            'isEnabled' => true,
            'extraQuota' => 0
        ];

        $clientService = $repository->updateClientService($clientService, $updateResource);

        $actual = [
            'serviceId' => $clientService->getServiceId(),
            'extras' => $clientService->getExtras(),
            'updatedBy' => $clientService->getUpdatedById(),
            'marketingQuota' => $clientService->getMarketingQuota(),
            'isEnabled' => $clientService->isEnabled(),
            'extraQuota' => $clientService->getExtraQuota()
        ];

        self::assertEquals($expected, $actual);
    }
}
