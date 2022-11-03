<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketEmails;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Tickets\TicketEmailsResource;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketEmailRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListTicketEmailController extends AbstractAPIController
{
    private TicketRepositoryInterface $ticketRepository;

    private TicketEmailRepositoryInterface $ticketEmailRepository;

    public function __construct(
        TicketEmailRepositoryInterface $ticketEmailRepository,
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->ticketEmailRepository = $ticketEmailRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(PaginationRequest $request, int $id): JsonResource
    {
        /** @var Ticket $ticket */
        $ticket = $this->ticketRepository->find($id);

        if ($ticket === null) {
            return $this->respondNotFound([
                'message' => 'Ticket not found.',
            ]);
        }

        try {
            $ticketEmails = $this->ticketEmailRepository->findByTicket(
                $ticket,
                $request->getSize(),
                $request->getPageNumber(),
            );

            return new TicketEmailsResource($ticketEmails);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
