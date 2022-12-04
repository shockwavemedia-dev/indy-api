<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Departments;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\API\Services\ServiceResource;
use App\Http\Resources\Resource;
use App\Models\Department;

final class DepartmentWithStaffsResource extends Resource
{
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

        foreach ($adminUsers as $adminUser) {
            $users[] = [
                'admin_user_id' => $adminUser->getId(),
                'role' => $adminUser->getRole(),
                'first_name' => $adminUser->getUser()?->getFirstName(),
                'middle_name' => $adminUser->getUser()?->getMiddleName(),
                'last_name' => $adminUser->getUser()?->getLastName(),
                'full_name' => \sprintf(
                    '%s %s %s',
                    $adminUser->getUser()?->getFirstName(),
                    $adminUser->getUser()?->getMiddleName(),
                    $adminUser->getUser()?->getLastName(),
                ),
                'open_tickets' => $adminUser->getOpenTickets(),
            ];
        }

        $result['users'] = $users;

        return $result;
    }
}
