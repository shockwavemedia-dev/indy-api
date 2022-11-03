<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users;

use App\Enum\AdminRoleEnum;
use App\Enum\UserTypeEnum;
use App\Models\Department;
use App\Models\Users\AdminUser;
use App\Services\Users\Exceptions\InvalidDepartmentsException;
use App\Services\Users\Resources\CreateAdminUserResource;
use App\Services\Users\UserAdminCreationService;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Repositories\AdminUserRepositoryStub;
use Tests\Stubs\Repositories\DepartmentRepositoryStub;

/**
 * @covers \App\Services\Users\UserAdminCreationService
 */
final class UserAdminCreationServiceTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\Users\Exceptions\InvalidDepartmentsException
     */
    public function testCreateSuccess(): void
    {
        $adminUser = new AdminUser();

        $department = new Department();
        $department->setAttribute('id', 1);

        $adminUserRepository = new AdminUserRepositoryStub([
            'create' => $adminUser,
            'setDepartments' => $adminUser,
        ]);

        $userAdminCreationService = new UserAdminCreationService($adminUserRepository);

        $resource = new CreateAdminUserResource([
            'role' => new AdminRoleEnum(AdminRoleEnum::ADMIN),
            'departments' => [$department->getId()],
        ]);

        $expectedCalls = [
            'adminUserRepository' => [
                [
                    'create' => [
                        [
                            "admin_role" => "admin",
                        ],
                    ],
                ],
            ],
        ];

        $userAdminCreationService->create($resource);

        $actualCalls = [
            'adminUserRepository' => $adminUserRepository->getCalls(),
        ];


        $this->assertEquals($expectedCalls, $actualCalls);
    }

    /**
     * @dataProvider getSupportTestCase
     */
    public function testSupports(bool $expected, UserTypeEnum $userType): void
    {
        $userAdminCreationService = new UserAdminCreationService(
            new AdminUserRepositoryStub(),
        );

         $this->assertEquals($expected, $userAdminCreationService->supports($userType));
    }

    /**
     * Data provider.
     */
    public function getSupportTestCase(): iterable
    {
        yield 'Supports true' => [
            'expected' => true,
            'userType' => new UserTypeEnum(UserTypeEnum::ADMIN)
        ];

        yield 'Supports false' => [
            'expected' => false,
            'userType' => new UserTypeEnum(UserTypeEnum::CLIENT)
        ];
    }
}
