<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Factories;

use App\Enum\UserTypeEnum;
use App\Models\Users\LeadClient;
use App\Services\Users\Factories\LeadClientFactory;
use App\Services\Users\Resources\CreateLeadClientResource;
use Tests\Stubs\Repositories\LeadClientRepositoryStub;
use Tests\TestCase;

/**
 * @covers \App\Services\Users\Factories\LeadClientFactory
 */
final class LeadClientFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testCreateSuccess(): void
    {
        $leadClient = new LeadClient();

        $repository = new LeadClientRepositoryStub([
            'create' => $leadClient,
        ]);

        $factory = new LeadClientFactory($repository);

        $expected = [
            [
                'create' => [
                    [
                        'full_name' => 'test',
                        'company_name' => 'test',
                    ],
                ],
            ],
        ];

        $factory->create(new CreateLeadClientResource([
            'fullName' => 'test',
            'companyName' => 'test',
        ]));

        self::assertEquals($expected, $repository->getCalls());
    }

    /**
     * @dataProvider getSupportTestCase
     */
    public function testSupports(bool $expected, UserTypeEnum $userType): void
    {
        $userClientCreationService = new LeadClientFactory(new LeadClientRepositoryStub());

        $this->assertEquals($expected, $userClientCreationService->supports($userType));
    }

    /**
     * Data provider.
     */
    public function getSupportTestCase(): iterable
    {
        yield 'Supports true' => [
            'expected' => true,
            'userType' => new UserTypeEnum(UserTypeEnum::LEAD_CLIENT)
        ];

        yield 'Supports false' => [
            'expected' => false,
            'userType' => new UserTypeEnum(UserTypeEnum::CLIENT)
        ];
    }
}
