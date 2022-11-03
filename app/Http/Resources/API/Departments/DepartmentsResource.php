<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Departments;

use App\Http\Resources\Resource;
use App\Models\Department;

final class DepartmentsResource extends Resource
{
    private ?bool $withUsers = false;

    public function __construct($resource, ?bool $withUsers = false)
    {
        parent::__construct($resource);

        $this->withUsers = $withUsers;
    }

    protected function getResponse(): array
    {
        $departments = [];

        /** @var Department $department */
        foreach ($this->resource as $department) {
            if (count($department->getAdminUsers()) === 0 && $this->withUsers === true) {
                continue;
            }

            $departments['data'][] = new DepartmentResource($department, $this->withUsers);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $departments['page'] = $this->paginationResource($this->resource);

        return $departments;
    }
}
