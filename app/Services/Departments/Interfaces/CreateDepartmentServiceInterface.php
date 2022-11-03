<?php

declare(strict_types=1);

namespace App\Services\Departments\Interfaces;

use App\Models\Department;
use App\Services\Departments\Resources\CreateDepartmentResources;

interface CreateDepartmentServiceInterface
{
    public function create(CreateDepartmentResources $resources): Department;
}
