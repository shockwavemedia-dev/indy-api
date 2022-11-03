<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\Users;

use App\Enum\UserTypeEnum;
use App\Models\Users\Interfaces\UserTypeInterface;
use App\Services\Users\Interfaces\CreateUserTypeResourceInterface;
use App\Services\Users\Interfaces\UserTypeFactoryInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class UserAdminCreationServiceStub extends AbstractStub implements UserTypeFactoryInterface
{
    /**
     * @throws \Throwable
     */
    public function create(CreateUserTypeResourceInterface $resource): UserTypeInterface
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function supports(UserTypeEnum $userType): bool
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
