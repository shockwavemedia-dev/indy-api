<?php

declare(strict_types=1);

namespace App\Services\Users\Interfaces;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;

interface CheckUserPermissionInterface
{
    public function hasPermission(ClientRoleEnum|AdminRoleEnum $userType, string $module, string $action): bool;
}
