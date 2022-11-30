<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Tickets\FileFeedback;
use App\Services\TicketActivities\Interfaces\TicketActivityFactoryInterface;
use App\Services\TicketActivities\Resources\CreateTicketActivityResource;

final class FileFeedbackObserver
{
    private TicketActivityFactoryInterface $activityFactory;

    public function __construct(TicketActivityFactoryInterface $activityFactory)
    {
        $this->activityFactory = $activityFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function created(FileFeedback $fileFeedback): void
    {
        $ticket = $fileFeedback->getClientTicketFile()->getTicket();

        $this->activityFactory->make(new CreateTicketActivityResource([
            'ticket' => $ticket,
            'user' => $fileFeedback->getFeedbackBy(),
            'activity' => \sprintf(
                '%s added file feedback.',
                $fileFeedback->getFeedbackBy()->getFirstName()
            ),
        ]));
    }
}
