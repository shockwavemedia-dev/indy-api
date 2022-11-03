<?php

declare(strict_types=1);

namespace App\Services\TicketEmails;

use App\Enum\UserTypeEnum;
use App\Services\TicketEmails\Exceptions\TicketEmailSenderDriverNotFoundException;
use App\Services\TicketEmails\Interfaces\TicketEmailSenderFactoryInterface;
use App\Services\TicketEmails\Interfaces\TicketEmailSenderInterface;
use EonX\EasyUtils\CollectorHelper;

final class TicketEmailSenderFactory implements TicketEmailSenderFactoryInterface
{
    /**
     * @var mixed[]
     */
    private array $drivers;

    public function __construct(iterable $drivers) {
        $this->drivers = CollectorHelper::filterByClassAsArray(
            $drivers,
            TicketEmailSenderInterface::class
        );
    }

    /**
     * @throws TicketEmailSenderDriverNotFoundException
     */
    public function make(UserTypeEnum $userType): TicketEmailSenderInterface
    {
        /** @var TicketEmailSenderInterface $driver */
        foreach ($this->drivers as $driver) {
            if ($driver->supports($userType) === true) {
                return $driver;
            }
        }

        throw new TicketEmailSenderDriverNotFoundException();
    }
}
