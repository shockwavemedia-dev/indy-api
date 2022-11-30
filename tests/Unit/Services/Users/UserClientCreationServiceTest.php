<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use App\Enum\ClientRoleEnum;
use App\Enum\UserTypeEnum;
use App\Models\Client;
use App\Models\Users\ClientUser;
use App\Services\Users\Resources\CreateClientUserResource;
use App\Services\Users\UserClientCreationService;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\ClientUserRepositoryStub;

/**
 * @covers \App\Services\Users\UserClientCreationService
 */
final class UserClientCreationServiceTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testCreateSuccess(): void
    {
        $client = new Client();
        $client->setAttribute('id', 1);

        $clientUser = new ClientUser();

        $clientUserRepository = new ClientUserRepositoryStub([
            'create' => $clientUser,
        ]);

        $userClientCreationService = new UserClientCreationService($clientUserRepository);

        $resource = new CreateClientUserResource([
            'role' => new ClientRoleEnum(ClientRoleEnum::MARKETING),
            'client' => $client,
        ]);

        $expectedCall = [
            [
                'create' => [
                    [
                        'client_id' => $client->getId(),
                        'client_role' => ClientRoleEnum::MARKETING,
                    ],
                ],
            ],
        ];

        $userClientCreationService->create($resource);

        $this->assertEquals($expectedCall, $clientUserRepository->getCalls());
    }

    /**
     * @dataProvider getSupportTestCase
     */
    public function testSupports(bool $expected, UserTypeEnum $userType): void
    {
        $userClientCreationService = new UserClientCreationService(new ClientUserRepositoryStub());

        $this->assertEquals($expected, $userClientCreationService->supports($userType));
    }

    /**
     * Data provider.
     */
    public function getSupportTestCase(): iterable
    {
        yield 'Supports true' => [
            'expected' => false,
            'userType' => new UserTypeEnum(UserTypeEnum::ADMIN),
        ];

        yield 'Supports false' => [
            'expected' => true,
            'userType' => new UserTypeEnum(UserTypeEnum::CLIENT),
        ];
    }
}
