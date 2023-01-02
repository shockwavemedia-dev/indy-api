<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\Users;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;
use App\Services\Users\Interfaces\UserPermissionConfigResolverInterface;
use Tests\Stubs\AbstractStub;
use Throwable;

/**
 * @coversNothing
 */
final class UserPermissionConfigResolverStub extends AbstractStub implements UserPermissionConfigResolverInterface
{
    /**
     * @throws Throwable
     */
    public function resolve(AdminRoleEnum|ClientRoleEnum $userType, string $module): array
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
