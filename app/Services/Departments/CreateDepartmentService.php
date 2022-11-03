<?php

declare(strict_types=1);

namespace App\Services\Departments;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Services\Departments\Interfaces\CreateDepartmentServiceInterface;
use App\Services\Departments\Resources\CreateDepartmentResources;

final class CreateDepartmentService implements CreateDepartmentServiceInterface
{    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function create(CreateDepartmentResources $resources): Department
    {
        /** @var Department $department */
        $department = $this->departmentRepository->create([
            'name' => $resources->getName(),
            'description' => $resources->getDescription(),
            'status' => $resources->getStatus(),
            'min_delivery_days' => $resources->getMinDeliveryDays(),
        ]);

        $department->services()->attach($resources->getServiceIds());

        $department->save();

        return $department;
    }
}
