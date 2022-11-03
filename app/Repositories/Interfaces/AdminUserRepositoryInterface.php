<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Enum\AdminRoleEnum;
use App\Models\Department;
use App\Models\Users\AdminUser;
use Illuminate\Database\Eloquent\Collection;

interface AdminUserRepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection<AdminUser>
     */
    public function findAccountManagersByDepartment(Department $department): Collection;

    public function findByRole(AdminRoleEnum $adminRoleEnum): Collection;

    public function findStaffByIds(array $ids = []): Collection;

    public function setDepartments(AdminUser $adminUser, array $ids): AdminUser;

    public function setDepartment(AdminUser $adminUser, int $departmentId): AdminUser;
}
