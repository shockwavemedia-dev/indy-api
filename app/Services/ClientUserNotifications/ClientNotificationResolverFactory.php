<?php

declare(strict_types=1);

namespace App\Services\ClientUserNotifications;

use App\Enum\ClientNotificationTypeEnum;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverFactoryInterface;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverInterface;
use EonX\EasyUtils\CollectorHelper;
use Exception;

final class ClientNotificationResolverFactory implements ClientNotificationResolverFactoryInterface
{
    /**
     * @var \App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverInterface[]
     */
    private array $drivers;

    public function __construct(iterable $drivers)
    {
        $this->drivers = CollectorHelper::filterByClassAsArray(
            $drivers,
            ClientNotificationResolverInterface::class
        );
    }

    /**
     * @throws Exception
     */
    public function make(ClientNotificationTypeEnum $typeEnum): ClientNotificationResolverInterface
    {
        foreach ($this->drivers as $driver) {
            if ($driver->supports($typeEnum) === true) {
                return $driver;
            }
        }

        throw new Exception('Invalid notification driver');
    }
}
