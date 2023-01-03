<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Enum\UserTypeEnum;
use App\Models\Department;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use App\Services\Users\Interfaces\CreateUserTypeResourceInterface;
use App\Services\Users\Interfaces\UserTypeFactoryInterface;
use App\Services\Users\Resources\CreateAdminUserResource;

final class UserAdminCreationService implements UserTypeFactoryInterface
{
    private AdminUserRepositoryInterface $repository;

    public function __construct(
        AdminUserRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @throws \App\Services\Users\Exceptions\InvalidDepartmentsException
     */
    public function create(CreateAdminUserResource|CreateUserTypeResourceInterface $resource): AdminUser
    {
        /** @var \App\Models\Users\AdminUser $adminUser */
        $adminUser = $this->repository->create([
            'admin_role' => $resource->getRole(),
        ]);

        if ($resource->getDepartmentId() === null) {
            return $adminUser;
        }

        $department = Department::where('id', $resource->getDepartmentId())->first();

        $adminUser->departments()->attach($resource->getDepartmentId(), ['position' => $resource->getPosition()]);

        return $adminUser;
    }

    public function supports(UserTypeEnum $userType): bool
    {
        return $userType->getValue() === UserTypeEnum::ADMIN;
    }
}
