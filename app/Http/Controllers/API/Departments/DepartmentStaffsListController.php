<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Departments;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Departments\StaffsResource;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DepartmentStaffsListController extends AbstractAPIController
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $department = $this->departmentRepository->find($id);

        if ($department === null) {
            return $this->respondNotFound([
                'message' => 'Department not found.',
            ]);
        }

        return new StaffsResource($department->getStaffs());
    }
}
