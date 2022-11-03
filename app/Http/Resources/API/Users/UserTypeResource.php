<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Users;

use App\Enum\UserTypeEnum;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\Users\Interfaces\UserTypeInterface;

final class UserTypeResource extends Resource
{
    /**
     * @return mixed[]
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof UserTypeInterface) === false) {
            throw new InvalidResourceTypeException(
                UserTypeInterface::class
            );
        }

        $userType = $this->resource;

        $result = [
            'id' => $userType->getId(),
            'type' => $userType->getType()->getValue(),
            'role' => $userType->getRole(),
        ];

        if ($userType->getType()->getValue() === UserTypeEnum::CLIENT) {
            $result['client'] = $userType->getClient();
        }

        if ($userType->getType()->getValue() === UserTypeEnum::ADMIN) {
            $adminDepartment = $userType->getDepartments()?->first();

            $result['department'] = $adminDepartment;
            $result['position'] = $adminDepartment?->pivot?->position ?? null;
        }

        return $result;
    }
}
