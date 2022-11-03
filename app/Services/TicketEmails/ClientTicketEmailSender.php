<?php

declare(strict_types=1);

namespace App\Services\TicketEmails;

use App\Enum\UserTypeEnum;
use App\Models\Tickets\TicketEmail;
use App\Services\TicketEmails\Interfaces\TicketEmailSenderInterface;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class ClientTicketEmailSender extends AbstractTicketEmailSender implements TicketEmailSenderInterface
{
    /**
     * @throws UnknownProperties
     */
    public function send(TicketEmail $ticketEmail): void
    {
        $ticket = $ticketEmail->getTicket();

        $this->sendEmail(
            $ticket->getRequestedBy(),
            $ticketEmail
        );
    }

    public function supports(UserTypeEnum $type): bool
    {
        return $type->getValue() === UserTypeEnum::ADMIN;
    }
}
