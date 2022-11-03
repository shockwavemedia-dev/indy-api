<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Department;
use App\Services\Departments\Resources\CreateDepartmentResources;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DepartmentRepositoryInterface
{
    /**
     * @param int[] $adminUserIds
     */
    public function addMembers(Department $department, array $adminUserIds): Department;

    public function all(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function allWithStaffs(?int $size = null, ?int $pageNumber = null): LengthAwarePaginator;

    public function findWithMembers(int $id): ?Department;

    public function findWithStaffs(int $id): ?Department;

    public function countDepartments(array $ids): int;

    public function deleteDepartment(Department $department): void;

    /**
     * @param int[] $adminUserIds
     */
    public function deleteMembers(Department $department, array $adminUserIds): Department;

    public function findByName(string $name): ?Department;

    public function findByNameLike(string $name): ?Department;

    public function update(Department $department, CreateDepartmentResources $resource): Department;
}
