<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Departments;

use App\Http\Resources\Resource;
use App\Models\Department;

final class DepartmentsWithStaffsResource extends Resource
{
    private ?bool $withUsers = false;

    protected function getResponse(): array
    {
        $departments = [];

        /** @var Department $department */
        foreach ($this->resource as $department) {
            $departments['data'][] = new DepartmentWithStaffsResource($department);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $departments['page'] = $this->paginationResource($this->resource);

        return $departments;
    }
}
