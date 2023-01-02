<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enum\AdminRoleEnum;
use App\Models\Users\AdminUser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\Users\AdminUser
 */
final class AdminUserTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'admin_role' => AdminRoleEnum::STAFF,
        ];

        $adminUser = new AdminUser();
        $adminUser->setAttribute('id', 1);
        $adminUser->setRole(AdminRoleEnum::STAFF);

        $actual = [
            'id' => $adminUser->getId(),
            'admin_role' => $adminUser->getRole(),
        ];

        self::assertEquals($expected, $actual);
    }
}
