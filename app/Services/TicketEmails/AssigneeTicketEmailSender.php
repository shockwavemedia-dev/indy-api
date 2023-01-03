<?php

declare(strict_types=1);

namespace App\Services\TicketEmails;

use App\Enum\UserTypeEnum;
use App\Models\Tickets\TicketEmail;
use App\Services\TicketEmails\Interfaces\TicketEmailSenderInterface;

final class AssigneeTicketEmailSender extends AbstractTicketEmailSender implements TicketEmailSenderInterface
{
    public function send(TicketEmail $ticketEmail): void
    {
        $assignees = $ticketEmail->getTicket()->getTicketAssignees();

        if ($assignees->count() === 0) {
            return;
        }

        foreach ($assignees as $assignee) {
            $adminUser = $assignee->getAdminUser();

            $this->sendEmail($adminUser->getUser(), $ticketEmail);
        }
    }

    public function supports(UserTypeEnum $type): bool
    {
        return $type->getValue() === UserTypeEnum::CLIENT;
    }
}
