<?php

namespace App\Services\TicketEmails\Interfaces;

use App\Enum\UserTypeEnum;
use App\Services\TicketEmails\Exceptions\TicketEmailSenderDriverNotFoundException;

interface TicketEmailSenderFactoryInterface
{
    /**
     * @throws TicketEmailSenderDriverNotFoundException
     */
    public function make(UserTypeEnum $userType): TicketEmailSenderInterface;
}
