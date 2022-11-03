<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use App\Enum\AdminRoleEnum;
use App\Services\Users\CheckUserPermission;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Services\Users\UserPermissionConfigResolverStub;

/**
 * @covers \App\Services\Users\CheckUserPermission
 */
final class CheckUserPermissionTest extends TestCase
{
    /**
     * Data provider.
     */
    public function getPermissionEventData(): iterable
    {
        $userType = new AdminRoleEnum(AdminRoleEnum::ADMIN);

        yield 'Has Permission True' => [
            'config' => [
                'read' => true,
                'delete' => true,
                'edit' => true,
                'create' => true,
            ],
            'userType' => $userType,
            'users',
            'action' => 'read',
            'expected' => true,
            'expectedCalls' => [
                [
                    'resolve' => [
                        $userType,
                        'users'
                    ],
                ],
            ],
        ];

        yield 'Has Permission False - Action not allowed' => [
            'config' => [
                'read' => false,
                'delete' => true,
                'edit' => true,
                'create' => true,
            ],
            'userType' => $userType,
            'users',
            'action' => 'read',
            'expected' => false,
            'expectedCalls' => [
                [
                    'resolve' => [
                        $userType,
                        'users'
                    ],
                ],
            ],
        ];

    }

    /**
     * @dataProvider getPermissionEventData
     */
    public function testHasPermission(
        array $config,
        $userType,
        string $module,
        string $action,
        bool $expected,
        array $expectedCalls
    ): void {
        $config = new UserPermissionConfigResolverStub([
            'resolve' => $config
        ]);

        $checkPermission = new CheckUserPermission($config);

        $actual = $checkPermission->hasPermission($userType, $module, $action);

        $this->assertEquals($expectedCalls, $config->getCalls());
        $this->assertEquals($expected, $actual);
    }
}
