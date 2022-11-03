<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Departments;

use App\Http\Resources\Resource;
use App\Models\Department;

final class StaffsResource extends Resource
{
    public static $wrap = null;

    protected function getResponse(): array
    {
        $staffs = [];

        foreach ($this->resource as $staff) {
            $staffs[] = new StaffResource($staff);
        }

        return $staffs;
    }
}
