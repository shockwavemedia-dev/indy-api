<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Enum\ClientStatusEnum;
use App\Repositories\ClientRepository;
use App\Services\Clients\Resources\UpdateClientResource;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * @covers \App\Repositories\ClientRepository
 */
final class ClientRepositoryTest extends TestCase
{
    public function testDeleteClient(): void
    {
        $client = $this->env->client()->client;

        $repository = new ClientRepository();

        $repository->deleteClient($client);

        $client->refresh();

        $this->assertEquals(ClientStatusEnum::DELETED, $client->getStatus()->getValue());
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\Users\Exceptions\InvalidDepartmentsException
     */
    public function testUpdateClientSuccess(): void
    {
        $client = $this->env->client()->client;

        $updateResource = new UpdateClientResource([
            'name' => 'Test Company Demo',
            'clientCode' => 'TCP',
            'address' => '123 Clyde St, Batemans Bay NSW 2536',
            'phone' => '(02) 4472 9131',
            'timezone' => '(UTC+10:00) Canberra, Melbourne, Sydney',
            'clientSince' => (new Carbon('01/01/2022')),
            'mainClientId' => null,
            'overview' => 'this is demo company',
            'rating' => 5,
            'status' => new ClientStatusEnum(ClientStatusEnum::ACTIVE),
            'logo_file_id' => null,
            'designated_designer_id' => null,
        ]);

        $repository = new ClientRepository();

        $expected = [
            'name' => 'Test Company Demo',
            'clientCode' => 'TCP',
            'address' => '123 Clyde St, Batemans Bay NSW 2536',
            'phone' => '(02) 4472 9131',
            'timezone' => '(UTC+10:00) Canberra, Melbourne, Sydney',
            'clientSince' => (new Carbon('01/01/2022')),
            'mainClientId' => null,
            'overview' => 'this is demo company',
            'rating' => 5,
            'status' => new ClientStatusEnum(ClientStatusEnum::ACTIVE),
            'logo' => null,
            'designated_designer' => null,
        ];

        $client = $repository->update($client, $updateResource);

        $actual = [
            'name' => $client->getName(),
            'clientCode' => $client->getClientCode(),
            'address' => $client->getAddress(),
            'phone' => $client->getPhone(),
            'timezone' => $client->getTimezone(),
            'clientSince' => $client->getClientSince(),
            'mainClientId' => $client->getMainClientId(),
            'overview' => $client->getOverview(),
            'rating' => $client->getRating(),
            'status' => $client->getStatus(),
            'logo' => $client->getLogo(),
            'designated_designer' => $client->getDesignatedDesigner(),
        ];

        self::assertEquals($expected, $actual);
    }

    public function testFindAllClient(): void
    {
        $client = $this->env->client()->client;

        $repository = new ClientRepository();

        $results = $repository->findAllClient();

        /** @var \App\Models\Client $actual */
        $actual = $results->find($client->getId());

        $arrayActual = \json_decode(\json_encode($actual), true);

        $this->assertEquals($client->getId(), $actual->getId());

        $this->assertArrayHasKeys(
            [
                'name',
                'client_code',
                'address',
                'phone',
                'timezone',
                'client_since',
                'main_client_id',
                'overview',
                'rating',
                'status',
                'logo_file_id',
                'designated_designer_id',
            ],
            $arrayActual
        );
    }
}
