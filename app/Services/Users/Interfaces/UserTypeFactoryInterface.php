<?php

declare(strict_types=1);

namespace App\Services\Users\Interfaces;

use App\Enum\UserTypeEnum;
use App\Models\Users\Interfaces\UserTypeInterface;

interface UserTypeFactoryInterface
{
    public function create(CreateUserTypeResourceInterface $resource): UserTypeInterface;

    public function supports(UserTypeEnum $userType): bool;
}
