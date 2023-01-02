<?php

declare(strict_types=1);

namespace App\Services\TicketAssignee;

use App\Enum\ServicesEnum;
use App\Services\TicketAssignee\Interfaces\DesignatorResolverFactoryInterface;
use App\Services\TicketAssignee\Interfaces\DesignatorResolverInterface;
use EonX\EasyUtils\CollectorHelper;
use Exception;

final class DesignatorResolverFactory implements DesignatorResolverFactoryInterface
{
    public function __construct(protected iterable $drivers)
    {
        $this->drivers = CollectorHelper::filterByClassAsArray(
            $drivers,
            DesignatorResolverInterface::class
        );
    }

    /**
     * @throws Exception
     */
    public function make(ServicesEnum $serviceType): DesignatorResolverInterface
    {
        /** @var DesignatorResolverInterface $driver */
        foreach ($this->drivers as $driver) {
            if ($driver->supports($serviceType) === true) {
                return $driver;
            }
        }

        throw new Exception('Invalid Designated Driver.');
    }
}
