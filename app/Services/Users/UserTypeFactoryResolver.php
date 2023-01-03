<?php

declare(strict_types=1);

namespace App\Services\Users;

use App\Enum\UserTypeEnum;
use App\Services\Users\Exceptions\UnsupportedUserTypeFactoryDriver;
use App\Services\Users\Interfaces\UserTypeFactoryInterface;
use App\Services\Users\Interfaces\UserTypeFactoryResolverInterface;
use EonX\EasyUtils\CollectorHelper;

final class UserTypeFactoryResolver implements UserTypeFactoryResolverInterface
{
    /**
     * @var UserTypeFactoryInterface[]
     */
    private array $drivers;

    public function __construct(iterable $drivers)
    {
        $this->drivers = CollectorHelper::filterByClassAsArray(
            $drivers,
            UserTypeFactoryInterface::class
        );
    }

    /**
     * @throws UnsupportedUserTypeFactoryDriver
     */
    public function make(UserTypeEnum $userType): UserTypeFactoryInterface
    {
        foreach ($this->drivers as $driver) {
            if ($driver->supports($userType)) {
                return $driver;
            }
        }

        throw new UnsupportedUserTypeFactoryDriver(
            \sprintf('No supported driver available user type (%s).', $userType->getValue())
        );
    }
}
