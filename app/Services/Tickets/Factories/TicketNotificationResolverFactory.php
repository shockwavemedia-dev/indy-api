<?php

declare(strict_types=1);

namespace App\Services\Tickets\Factories;

use _PHPStan_ae8980142\Nette\Neon\Exception;
use App\Enum\TicketNotificationTypeEnum;
use App\Services\Tickets\Interfaces\Factories\TicketNotificationResolverFactoryInterface;
use App\Services\Tickets\Interfaces\Resolvers\TicketNotificationResolverInterface;
use EonX\EasyUtils\CollectorHelper;

final class TicketNotificationResolverFactory implements TicketNotificationResolverFactoryInterface
{
    /**
     * @var \App\Services\Tickets\Interfaces\Resolvers\TicketNotificationResolverInterface[]
     */
    private array $drivers;

    public function __construct(iterable $drivers)
    {
        $this->drivers = CollectorHelper::filterByClassAsArray(
            $drivers,
            TicketNotificationResolverInterface::class
        );
    }

    /**
     * @throws Exception
     */
    public function make(TicketNotificationTypeEnum $typeEnum): TicketNotificationResolverInterface
    {
        foreach ($this->drivers as $driver) {
            if ($driver->supports($typeEnum) === true) {
                return $driver;
            }
        }

        throw new Exception('Invalid notification driver');
    }
}
