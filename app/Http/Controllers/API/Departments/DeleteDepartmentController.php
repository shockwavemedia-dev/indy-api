<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Departments;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class DeleteDepartmentController extends AbstractAPIController
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var Department $department */
        $department = $this->departmentRepository->find($id);

        if ($department === null) {
            return $this->respondNoContent();
        }

        try {
            $this->departmentRepository->deleteDepartment($department);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondNoContent();
        }
    }
}
