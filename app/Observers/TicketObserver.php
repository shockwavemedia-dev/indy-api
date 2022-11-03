<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enum\TicketTypeEnum;
use App\Models\Tickets\Ticket;
use App\Services\TicketActivities\Interfaces\TicketActivityFactoryInterface;
use App\Services\TicketActivities\Resources\CreateTicketActivityResource;

final class TicketObserver
{
    private TicketActivityFactoryInterface $activityFactory;

    public function __construct(
        TicketActivityFactoryInterface $activityFactory
    ) {
        $this->activityFactory = $activityFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function created(Ticket $ticket): void
    {
        $this->graphicTicketNotifyAdmins($ticket);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function updating(Ticket $ticket): void
    {
        $this->checkDescriptionActivity($ticket);
        $this->checkStatusActivity($ticket);
        $this->checkSubjectActivity($ticket);
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function checkDescriptionActivity(Ticket $ticket): void
    {
        if($ticket->isDirty('description') === false) {
            return;
        }

        $this->activityFactory->make(new CreateTicketActivityResource([
            'ticket' => $ticket,
            'user' => $ticket->getUpdatedBy(),
            'activity' => \sprintf(
                '%s updated the description.',
                $ticket->getUpdatedBy()->getFirstName(),
            )
        ]));
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function checkStatusActivity(Ticket $ticket): void
    {
        if($ticket->isDirty('status') === false && $ticket->getUpdatedBy() === null) {
            return;
        }

        if ($ticket->getStatus()->getValue() === $ticket->getOriginal('status')) {
            return;
        }

        if ($ticket->getUpdatedBy() === null) {
            return;
        }

        $this->activityFactory->make(new CreateTicketActivityResource([
            'ticket' => $ticket,
            'user' => $ticket->getUpdatedBy(),
            'activity' => \sprintf(
                '%s changed the status from %s to %s.',
                $ticket->getUpdatedBy()?->getFirstName(),
                ucfirst($ticket->getOriginal('status')),
                ucfirst($ticket->getStatus()->getValue()),
            )
        ]));
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    private function checkSubjectActivity(Ticket $ticket): void
    {
        if($ticket->isDirty('subject') === false) {
            return;
        }

        $this->activityFactory->make(new CreateTicketActivityResource([
            'ticket' => $ticket,
            'user' => $ticket->getUpdatedBy(),
            'activity' => \sprintf(
                '%s updated the subject to %s.',
                $ticket->getUpdatedBy()->getFirstName(),
                $ticket->getSubject(),
            )
        ]));
    }

    private function graphicTicketNotifyAdmins(Ticket $ticket): void
    {
        if ($ticket->getType()->getValue() !== TicketTypeEnum::GRAPHIC) {
            return;
        }

//        $this->graphicNotificationHandler->handle($ticket);
    }
}
