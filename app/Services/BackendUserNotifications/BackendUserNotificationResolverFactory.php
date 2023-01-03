<?php

declare(strict_types=1);

namespace App\Services\BackendUserNotifications;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverFactoryInterface;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverInterface;
use EonX\EasyUtils\CollectorHelper;
use Exception;

final class BackendUserNotificationResolverFactory implements BackendUserNotificationResolverFactoryInterface
{
    /**
     * @var BackendUserNotificationResolverInterface[]
     */
    private array $drivers;

    public function __construct(iterable $drivers)
    {
        $this->drivers = CollectorHelper::filterByClassAsArray(
            $drivers,
            BackendUserNotificationResolverInterface::class
        );
    }

    /**
     * @throws Exception
     */
    public function make(BackendUserNotificationTypeEnum $typeEnum): BackendUserNotificationResolverInterface
    {
        foreach ($this->drivers as $driver) {
            if ($driver->supports($typeEnum) === true) {
                return $driver;
            }
        }

        throw new Exception('Invalid notification driver');
    }
}
