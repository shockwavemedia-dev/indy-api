<?php

declare(strict_types=1);

namespace App\Services\TicketActivities;

use App\Models\Tickets\TicketActivity;
use App\Repositories\Interfaces\TicketActivityRepositoryInterface;
use App\Services\TicketActivities\Interfaces\TicketActivityFactoryInterface;
use App\Services\TicketActivities\Resources\CreateTicketActivityResource;

final class TicketActivityFactory implements TicketActivityFactoryInterface
{
    private TicketActivityRepositoryInterface $ticketActivityRepository;

    public function __construct(TicketActivityRepositoryInterface $ticketActivityRepository)
    {
        $this->ticketActivityRepository = $ticketActivityRepository;
    }

    public function make(CreateTicketActivityResource $resource): TicketActivity
    {
        /** @var TicketActivity $ticketActivity */
        $ticketActivity = $this->ticketActivityRepository->create([
            'ticket_id' => $resource->getTicket()->getId(),
            'user_id' => $resource->getUser()->getId(),
            'activity' => $resource->getActivity()
        ]);

        return $ticketActivity;
    }
}
