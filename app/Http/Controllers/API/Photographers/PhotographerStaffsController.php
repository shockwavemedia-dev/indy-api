<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Photographers;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Departments\StaffsResource;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class PhotographerStaffsController extends AbstractAPIController
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function __invoke(): JsonResource
    {
        /** @var Department $department */
        $department = $this->departmentRepository->findByNameLike('%Photographer%');

        if ($department === null) {
            return $this->respondNoContent();
        }

        return new StaffsResource($department->getStaffs());
    }
}
