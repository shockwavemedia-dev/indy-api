<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Enum\AdminRoleEnum;
use App\Repositories\AdminUserRepository;
use Tests\TestCase;

/**
 * @covers \App\Repositories\AdminUserRepository
 */
final class AdminUserRepositoryTest extends TestCase
{
    public function testFindStaffByIds(): void
    {
        $adminUser = $this->env->adminUser([
            'admin_role' => AdminRoleEnum::STAFF,
        ])->adminUser;

        $repository = new AdminUserRepository();

        $staffs = $repository->findStaffByIds([$adminUser->getId()]);

        /** @var \App\Models\Users\AdminUser $actual */
        $actual = $staffs->find($adminUser->getId());

        $this->assertNotNull($actual);
    }

    public function testSetDepartments(): void
    {
        $adminUser = $this->env->adminUser([
            'admin_role' => AdminRoleEnum::STAFF,
        ])->adminUser;

        $department = $this->env->department()->department;

        $repository = new AdminUserRepository();

        $adminUser = $repository->setDepartments($adminUser, [$department->getId()]);

        self::assertEquals(
            $department->getId(),
            $adminUser->getDepartments()->first()->getId()
        );
    }
}
