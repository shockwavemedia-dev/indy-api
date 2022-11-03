<?php

namespace App\Services\TicketEmails\Interfaces;

use App\Enum\UserTypeEnum;
use App\Models\Tickets\TicketEmail;
use App\Models\User;

interface TicketEmailSenderInterface
{
    public function send(TicketEmail $ticketEmail): void;

    public function supports(UserTypeEnum $type): bool;
}
