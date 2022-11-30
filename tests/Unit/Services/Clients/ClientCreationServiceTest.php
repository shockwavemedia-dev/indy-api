<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Clients;

use App\Enum\ClientStatusEnum;
use App\Models\Client;
use App\Services\Clients\ClientCreationService;
use App\Services\Clients\Resources\CreateClientResource;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\ClientRepositoryStub;

/**
 * @covers \App\Services\Clients\ClientCreationService
 */
final class ClientCreationServiceTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testCreateSuccess(): void
    {
        $client = new Client();
        $client->setAttribute('id', 1);

        $clientRepository = new ClientRepositoryStub([
            'create' => $client,
        ]);

        $resource = new CreateClientResource([
            'name' => 'Demo Company 1',
            'clientCode' => 'DC1',
            'address' => '13 Clyde St, Batemans Bay NSW 2536',
            'phone' => '(02) 4472 9131',
            'timezone' => '(UTC+10:00) Canberra, Melbourne, Sydney',
            'clientSince' => (new Carbon('01/01/2022')),
            'mainClientId' => null,
            'overview' => 'testOverview',
            'rating' => 5,
            'status' => new ClientStatusEnum(ClientStatusEnum::ACTIVE),
            'logo_file_id' => null,
            'designated_designer_id' => null,
        ]);

        $resolver = new ClientCreationService(
            $clientRepository
        );

        $expectedCall = [
            [
                'create' => [
                    [
                        'name' => 'Demo Company 1',
                        'client_code' => 'DC1',
                        'address' => '13 Clyde St, Batemans Bay NSW 2536',
                        'phone' => '(02) 4472 9131',
                        'timezone' => '(UTC+10:00) Canberra, Melbourne, Sydney',
                        'client_since' => (new Carbon('01/01/2022')),
                        'main_client_id' => null,
                        'overview' => 'testOverview',
                        'rating' => 5,
                        'status' => 'active',
                        'logo_file_id' => null,
                        'designated_designer_id' => null,
                        'style_guide' => null,
                        'note' => null,
                    ],
                ],
            ],
        ];

        $resolver->create($resource);

        $this->assertEquals($expectedCall, $clientRepository->getCalls());
    }
}
