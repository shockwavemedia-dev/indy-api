<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Departments;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Departments\DepartmentListRequest;
use App\Http\Resources\API\Departments\DepartmentsResource;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListDepartmentController extends AbstractAPIController
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function __invoke(DepartmentListRequest $request): JsonResource
    {
        /** @var \App\Models\Department $department */
        $departments = $this->departmentRepository->all(
            $request->getSize(),
            $request->getPageNumber()
        );

        return new DepartmentsResource($departments, $request->withUsers());
    }
}
