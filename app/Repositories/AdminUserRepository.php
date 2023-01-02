<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\AdminRoleEnum;
use App\Models\Department;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\AdminUserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class AdminUserRepository extends BaseRepository implements AdminUserRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new AdminUser());
    }

    /**
     * @param  Department  $department
     * @return Collection<AdminUser>
     */
    public function findAccountManagersByDepartment(Department $department): Collection
    {
        return $this->model
            ->where('admin_role', '=', AdminRoleEnum::ACCOUNT_MANAGER)
            ->whereHas('departments', function ($query) use ($department) {
                $query->where('department_id', '=', $department->getId());
            })
            ->with('user')
            ->get();
    }

    public function findByRole(AdminRoleEnum $adminRoleEnum): Collection
    {
        return $this->model
            ->where('admin_role', '=', $adminRoleEnum->getValue())
            ->get();
    }

    public function findStaffByIds(array $ids = []): Collection
    {
        return $this->model
            ->whereIn('id', $ids)
            ->get();
    }

    public function setDepartments(AdminUser $adminUser, array $ids): AdminUser
    {
        $adminUser->setDepartments($ids);
        $adminUser->save();

        return $adminUser;
    }

    public function setDepartment(AdminUser $adminUser, int $departmentId): AdminUser
    {
        $adminUser->setDepartments([$departmentId]);
        $adminUser->save();

        return $adminUser;
    }
}
