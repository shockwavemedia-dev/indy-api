<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enum\EmailStatusEnum;
use App\Events\Tickets\TicketAssignedEvent;
use App\Jobs\Tickets\AssignedTicketSlackNotificationJob;
use App\Models\Tickets\TicketAssignee;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use App\Services\TicketActivities\Interfaces\TicketActivityFactoryInterface;
use App\Services\TicketActivities\Resources\CreateTicketActivityResource;

final class TicketAssigneeObserver
{
    private TicketActivityFactoryInterface $activityFactory;

    private EmailLogFactoryInterface $emailLogFactory;

    public function __construct(
        EmailLogFactoryInterface $emailLogFactory,
        TicketActivityFactoryInterface $activityFactory
    ) {
        $this->emailLogFactory = $emailLogFactory;
        $this->activityFactory = $activityFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function created(TicketAssignee $ticketAssignee): void
    {
        $user = $ticketAssignee->getAdminUser()->getUser();

        $createdBy = $ticketAssignee->getCreatedBy()->getUser();

        $ticket = $ticketAssignee->getTicket();

        $username = $createdBy->getFirstName();

        if ($createdBy->getEmail() === 'superadmin@indy.com.au') {
            $username = 'The Indy Platform';
        }

        $message = \sprintf(
            'Hi %s, %s has assigned Ticket #%s to you.',
            $user->getFirstName(),
            $username,
            $ticket->getTicketCode(),
        );

        $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
            'message' => $message,
            'to' => $user->getEmail(),
            'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
            'emailType' => $ticketAssignee,
        ]));

        $user->assignedTicket($ticket, $createdBy, $emailLog);

        TicketAssignedEvent::dispatch($user, $ticket);

        AssignedTicketSlackNotificationJob::dispatch($createdBy, $user, $ticket);

        $this->activityFactory->make(new CreateTicketActivityResource([
            'ticket' => $ticket,
            'user' => $createdBy,
            'activity' => \sprintf(
                '%s assigned this ticket # %s to %s',
                $createdBy->getFirstName(),
                $ticket->getTicketCode(),
                $user->getFirstName(),
            ),
        ]));
    }
}
