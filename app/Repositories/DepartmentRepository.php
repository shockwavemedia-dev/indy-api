<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\AdminRoleEnum;
use App\Enum\DepartmentStatusEnum;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Services\Departments\Resources\CreateDepartmentResources;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

final class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Department());
    }

    /**
     * @param  mixed  $adminUserIds
     */
    public function addMembers(Department $department, array $adminUserIds): Department
    {
        $department->adminUsers()->syncWithoutDetaching($adminUserIds);
        $department->save();

        return $department;
    }

    public function all(?int $size = null, ?int $pageNumber = null, bool $withUser = false): LengthAwarePaginator
    {
        $query = $this->model
            ->where('status', '=', DepartmentStatusEnum::ACTIVE);

        if ($withUser === true) {
            $query->with('adminUsers.user');
        }

        return $query->paginate(
            $size,
            ['*'],
            null,
            $pageNumber
        );
    }

    public function allWithStaffs(?int $size = null, ?int $pageNumber = null, bool $withUser = false): LengthAwarePaginator
    {
        $query = $this->model
            ->where('status', '=', DepartmentStatusEnum::ACTIVE)
            ->with('adminUsers', function ($query) {
//                $query->where('admin_role', '=', AdminRoleEnum::STAFF);
            });

        return $query->paginate(
            $size,
            ['*'],
            null,
            $pageNumber
        );
    }

    public function findWithMembers(int $id): ?Department
    {
        /** @var Department $department */
        $department = $this->model
            ->with(['services', 'adminUsers'])
            ->where('id', $id)
            ->first();

        return $department;
    }

    public function findWithStaffs(int $id): ?Department
    {
        $result = $this->model
            ->where('id', $id)
            ->with('adminUsers', function ($query) {
                $query->where('admin_role', '=', AdminRoleEnum::STAFF);
            })
            ->get();

        return Arr::get($result, 0);
    }

    public function countDepartments(array $ids): int
    {
        return $this->model->whereIn('id', $ids)->count();
    }

    public function deleteDepartment(Department $department): void
    {
        $department->setStatus(new DepartmentStatusEnum(DepartmentStatusEnum::DELETED));

        $department->delete();

        $department->save();
    }

    public function findByName(string $name): ?Department
    {
        return $this->model->where('name', '=', $name)
            ->whereHas('adminUsers', function ($query) {
                $query->whereHas('user', function ($query) {
                    $query->whereNull('deleted_at');
                });
            })
            ->with('adminUsers')
            ->first();
    }

    public function update(Department $department, CreateDepartmentResources $resource): Department
    {
        if ($resource->getServiceIds() !== null) {
            $department->services()->detach();
            $department->services()->attach($resource->getServiceIds());
        }

        $department->setName($resource->getName());
        $department->setDescription($resource->getDescription());
        $department->setStatus($resource->getStatus());
        $department->setMinimumDeliveryDays($resource->getMinDeliveryDays());
        $department->save();

        return $department;
    }

    public function deleteMembers(Department $department, array $adminUserIds): Department
    {
        $department->adminUsers()->detach($adminUserIds);
        $department->save();

        return $department;
    }

    public function findByNameLike(string $name): ?Department
    {
        return $this->model->where('name', 'LIKE', $name)
            ->first();
    }
}
