<?php

declare(strict_types=1);

namespace App\Services\Users\Interfaces;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;
use App\Enum\UserTypeEnum;

interface UserPermissionConfigResolverInterface
{
    public function resolve(ClientRoleEnum|AdminRoleEnum $userType, string $module): array;
}
