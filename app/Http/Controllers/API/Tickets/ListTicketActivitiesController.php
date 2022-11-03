<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Tickets\TicketActivitiesResource;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Interfaces\TicketActivityRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListTicketActivitiesController extends AbstractAPIController
{
    private TicketRepositoryInterface $ticketRepository;
    private TicketActivityRepositoryInterface $ticketActivityRepository;

    public function __construct(
        TicketRepositoryInterface $ticketRepository,
        TicketActivityRepositoryInterface $ticketActivityRepository,
    ) {
        $this->ticketRepository = $ticketRepository;
        $this->ticketActivityRepository = $ticketActivityRepository;
    }

    public function __invoke(PaginationRequest $request,int $id): JsonResource
    {
        /** @var \App\Models\Tickets\Ticket $ticket */
        $ticket = $this->ticketRepository->find($id);

        if ($ticket === null) {
            return $this->respondNotFound([
                'message' => 'Ticket not found.',
            ]);
        }

        try {
            $activity = $this->ticketActivityRepository->findAllTicketActivities($ticket,$request->getSize(), $request->getPageNumber());

            return new TicketActivitiesResource($activity);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
