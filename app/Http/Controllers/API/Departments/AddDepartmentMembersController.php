<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Departments;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Departments\AddDepartmentMembersRequest;
use App\Http\Resources\API\Departments\DepartmentWithMembersResource;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class AddDepartmentMembersController extends AbstractAPIController
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function __invoke(AddDepartmentMembersRequest $request, int $id): JsonResource
    {
        /** @var Department $department */
        $department = $this->departmentRepository->find($id);

        if ($department === null) {
            return $this->respondNotFound([
                'message' => 'Department not found.',
            ]);
        }

        $department = $this->departmentRepository->addMembers(
            $department,
            $request->getAdminUserIds()
        );

        return new DepartmentWithMembersResource($department);
    }
}
