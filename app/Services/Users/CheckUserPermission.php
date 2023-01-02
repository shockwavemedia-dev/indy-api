<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;
use App\Services\Users\Interfaces\CheckUserPermissionInterface;
use App\Services\Users\Interfaces\UserPermissionConfigResolverInterface;
use Illuminate\Support\Arr;

final class CheckUserPermission implements CheckUserPermissionInterface
{
    private UserPermissionConfigResolverInterface $configResolver;

    public function __construct(UserPermissionConfigResolverInterface $configResolver)
    {
        $this->configResolver = $configResolver;
    }

    public function hasPermission(ClientRoleEnum|AdminRoleEnum $userType, string $module, string $action): bool
    {
        $permissions = $this->configResolver->resolve($userType, $module);

        return Arr::get($permissions, $action, false);
    }
}
