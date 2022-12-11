<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Departments;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\API\Services\ServiceResource;
use App\Http\Resources\Resource;
use App\Models\Department;
use App\Models\Users\AdminUser;

final class DepartmentWithMembersResource extends Resource
{
    public static $wrap = null;

    /**
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Department) === false) {
            throw new InvalidResourceTypeException(
                Department::class
            );
        }

        /** @var \App\Models\Department $department */
        $department = $this->resource;

        $services = [];

        foreach ($department->getServices() as $service) {
            $services[] = new ServiceResource($service);
        }

        $result = [
            'id' => $department->getId(),
            'name' => $department->getName(),
            'description' => $department->getDescription(),
            'status' => $department->getStatus()->getValue(),
            'min_delivery_days' => $department->getMinDeliveryDays(),
            'services' => $services,
        ];

        $adminUsers = $department->getAdminUsers() ?? [];

        $users = [];

        /** @var AdminUser $adminUser */
        foreach ($adminUsers as $adminUser) {
            if ($adminUser->getUser() === null) {
                continue;
            }

            $users[] = [
                'admin_user_id' => $adminUser->getId(),
                'role' => $adminUser->getRole(),
                'first_name' => $adminUser->getUser()->getFirstName(),
                'middle_name' => $adminUser->getUser()->getMiddleName(),
                'last_name' => $adminUser->getUser()->getLastName(),
                'full_name' => $adminUser->getUser()->getFullName(),
            ];
        }

        $result['members'] = $users;

        return $result;
    }
}
