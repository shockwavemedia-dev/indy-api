<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Tickets\TicketEmail;
use App\Services\TicketActivities\Interfaces\TicketActivityFactoryInterface;
use App\Services\TicketActivities\Resources\CreateTicketActivityResource;

final class TicketEmailObserver
{
    private TicketActivityFactoryInterface $activityFactory;

    public function __construct(TicketActivityFactoryInterface $activityFactory) {
        $this->activityFactory = $activityFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function created(TicketEmail $ticketEmail): void
    {
        $this->activityFactory->make(new CreateTicketActivityResource([
            'ticket' => $ticketEmail->getTicket(),
            'user' => $ticketEmail->getSenderBy(),
            'activity' => \sprintf(
                '%s sent an email',
                $ticketEmail->getSenderBy()->getFirstName(),
            )
        ]));
    }
}
