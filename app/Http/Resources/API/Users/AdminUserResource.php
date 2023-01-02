<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Users;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Department;
use App\Models\Users\AdminUser;

final class AdminUserResource extends Resource
{
    /**
     * @throws \App\Exceptions\InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof AdminUser) === false) {
            throw new InvalidResourceTypeException(
                AdminUser::class,
            );
        }

        /** @var \App\Models\Users\AdminUser $adminUser */
        $adminUser = $this->resource;

        /** @var Department $department */
        $department = $adminUser->getDepartments()->first();

        return [
            'admin_user_id' => $adminUser->getId(),
            'role' => $adminUser->getRole(),
            'first_name' => $adminUser->getUser()->getFirstName(),
            'middle_name' => $adminUser->getUser()->getMiddleName(),
            'last_name' => $adminUser->getUser()->getLastName(),
            'department_name' => $department?->getName(),
            'department_id' => $department?->getId(),
        ];
    }
}
