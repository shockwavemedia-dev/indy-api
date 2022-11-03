<?php

declare(strict_types=1);

namespace App\Services\TicketEmails;

use App\Enum\EmailStatusEnum;
use App\Models\Tickets\TicketEmail;
use App\Models\User;
use App\Notifications\SendTicketEmail;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;

abstract class AbstractTicketEmailSender
{
    private EmailLogFactoryInterface $emailLogFactory;

    public function __construct(EmailLogFactoryInterface $emailLogFactory)
    {
        $this->emailLogFactory = $emailLogFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function sendEmail(User $user, TicketEmail $ticketEmail): void
    {
        $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
            'emailType' => $ticketEmail,
            'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
            'to' => $user->getEmail(),
            'message' => 'Ticket Email', // Static message, real email is in json format
        ]));

        $user->notify(new SendTicketEmail($ticketEmail, $ticketEmail->getTicket(), $emailLog));
    }
}
