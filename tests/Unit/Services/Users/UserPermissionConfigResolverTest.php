<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use App\Enum\AdminRoleEnum;
use App\Services\Users\UserPermissionConfigResolver;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\ThirdParty\Illuminate\Config\Repository\ConfigStub;

/**
 * @covers \App\Services\Users\UserPermissionConfigResolver
 */
final class UserPermissionConfigResolverTest extends TestCase
{
    public function testResolveSuccess(): void
    {
        $expected = [
            'read' => true,
            'delete' => true,
            'edit' => true,
            'create' => true,
        ];

        $config = new ConfigStub([
            'get' => [
                AdminRoleEnum::ADMIN => [
                    'modules' => [
                        'users' => $expected,
                    ],
                ],
            ],
        ]);

        $userPermissionConfigResolver = new UserPermissionConfigResolver($config);

        $userType = new AdminRoleEnum(AdminRoleEnum::ADMIN);

        $actual = $userPermissionConfigResolver->resolve($userType, 'users');

        self::assertEquals($expected, $actual);
    }

    public function testResolveInvalidUserType(): void
    {
        $config = new ConfigStub([
            'get' => [
                AdminRoleEnum::ADMIN => [
                    'modules' => [
                        'users' => [
                            'read' => true,
                            'delete' => true,
                            'edit' => true,
                            'create' => true,
                        ],
                    ],
                ],
            ],
        ]);

        $userPermissionConfigResolver = new UserPermissionConfigResolver($config);

        $userType = new AdminRoleEnum(AdminRoleEnum::STAFF);

        $actual = $userPermissionConfigResolver->resolve($userType, 'users');

        self::assertEquals([], $actual);
    }

    public function testResolveNoPermissions(): void
    {
        $config = new ConfigStub([
            'get' => [
                AdminRoleEnum::ADMIN => [
                    'modules' => [
                        'users' => [],
                    ],
                ],
            ],
        ]);

        $userPermissionConfigResolver = new UserPermissionConfigResolver($config);

        $userType = new AdminRoleEnum(AdminRoleEnum::ADMIN);

        $actual = $userPermissionConfigResolver->resolve($userType, 'clients');

        self::assertEquals([], $actual);
    }
}
