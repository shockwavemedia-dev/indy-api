<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use App\Models\Users\AdminUser;
use App\Services\Users\Exceptions\UnsupportedUserTypeFactoryDriver;
use App\Services\Users\Interfaces\UserTypeFactoryInterface;
use App\Services\Users\UserTypeFactoryResolver;
use Tests\Stubs\Services\Users\UserAdminCreationServiceStub;
use Tests\TestCase;

/**
 * @covers \App\Services\Users\UserTypeFactoryResolver
 */
final class UserTypeFactoryResolverTest extends TestCase
{
    /**
     * @throws \App\Services\Users\Exceptions\UnsupportedUserTypeFactoryDriver
     */
    public function testMakeSuccess(): void
    {
        $adminUser = new AdminUser();

        $userAdminCreationService = new UserAdminCreationServiceStub([
            'supports' => true,
        ]);

        $factory = new UserTypeFactoryResolver([$userAdminCreationService]);

        $expectedCalls = [
            [
                'supports' => [
                    $adminUser->getType(),
                ],
            ],
        ];

        $actual = $factory->make($adminUser->getType());

        $this->assertInstanceOf(UserTypeFactoryInterface::class, $actual);
        $this->assertEquals($expectedCalls, $userAdminCreationService->getCalls());
    }

    /**
     * @throws \App\Services\Users\Exceptions\UnsupportedUserTypeFactoryDriver
     */
    public function testMakeThrowsException(): void
    {
        $adminUser = new AdminUser();

        $userAdminCreationService = new UserAdminCreationServiceStub([
            'supports' => false,
        ]);

        $factory = new UserTypeFactoryResolver([$userAdminCreationService]);

        $this->expectException(UnsupportedUserTypeFactoryDriver::class);

        $actual = $factory->make($adminUser->getType());
    }
}
