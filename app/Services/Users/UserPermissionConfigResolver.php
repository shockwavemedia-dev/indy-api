<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;
use App\Services\Users\Interfaces\UserPermissionConfigResolverInterface;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;

final class UserPermissionConfigResolver implements UserPermissionConfigResolverInterface
{
    /**
     * @var string
     */
    private const USER_PERMISSIONS = 'user_permissions';

    private Repository $configRepository;

    public function __construct(Repository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function resolve(ClientRoleEnum|AdminRoleEnum $userType, string $module): array
    {
        $config = $this->configRepository->get(self::USER_PERMISSIONS);

        $user = Arr::get($config, $userType->getValue(), []);

        $modules = Arr::get($user, 'modules', []);

        return Arr::get($modules, $module, []);
    }
}
