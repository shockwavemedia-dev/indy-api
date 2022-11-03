<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Libraries;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Tickets\TicketSupportsResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListClientLibraryTicketsController extends AbstractAPIController
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

    public function __invoke(PaginationRequest $request,int $id): JsonResource
    {
        /** @var \App\Models\Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        try {
            $ticket = $this->ticketRepository->findLibraryTicketsByClient(
                $client,
                $request->getSize(),
                $request->getPageNumber()
            );

            return new TicketSupportsResource($ticket);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
