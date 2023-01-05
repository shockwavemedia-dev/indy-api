<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Tickets;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Tickets\TicketSupportsResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\Tickets\Resources\TicketFilterOptionsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListClientTicketController extends AbstractAPIController
{
    private TicketRepositoryInterface $ticketRepository;

    private ClientRepositoryInterface $clientRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(PaginationRequest $request, int $id): JsonResource
    {
        /** @var \App\Models\Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        try {
            $showOverdue = $request->get('show_overdue') ?? null;

            $showOverdue = filter_var($showOverdue, FILTER_VALIDATE_BOOLEAN);

            $ticket = $this->ticketRepository->findByClient(
                $client,
                new TicketFilterOptionsResource([
                    'code' => $request->getCode(),
                    'deadline' => $request->getDeadline(),
                    'types' => $request->getTypes(),
                    'statuses' => $request->getStatuses(),
                    'subject' => $request->getSubject(),
                    'priorities' => $request->getPriorities(),
                    'hideClosed' => $request->hideClosed(),
                ]),
                $request->getSize(),
                $request->getPageNumber()
            );

            return new TicketSupportsResource($ticket, $showOverdue);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
