<?php

declare(strict_types=1);

namespace App\Services\Tickets\Factories;

use App\Enum\TicketTypeEnum;
use App\Services\Tickets\Exceptions\UnsupportedTicketTypeException;
use App\Services\Tickets\Interfaces\Factories\TicketTypeResolverFactoryInterface;
use App\Services\Tickets\Interfaces\Resolvers\TicketTypeResolverInterface;
use EonX\EasyUtils\CollectorHelper;

final class TicketTypeResolverFactory implements TicketTypeResolverFactoryInterface
{
    /**
     * @var \App\Services\Tickets\Interfaces\Resolvers\TicketTypeResolverInterface[]
     */
    private array $drivers;

    public function __construct(iterable $drivers)
    {
        $this->drivers = CollectorHelper::filterByClassAsArray(
            $drivers,
            TicketTypeResolverInterface::class
        );
    }

    /**
     * @throws \App\Services\Tickets\Exceptions\UnsupportedTicketTypeException
     */
    public function make(TicketTypeEnum $type): TicketTypeResolverInterface
    {
        foreach ($this->drivers as $driver) {
            if ($driver->supports($type)) {
                return $driver;
            }
        }

        throw new UnsupportedTicketTypeException(
            \sprintf('No supported driver available ticket type (%s).', $type->getValue())
        );
    }
}
