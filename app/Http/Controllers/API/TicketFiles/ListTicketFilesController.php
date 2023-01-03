<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\TicketFiles\TicketFilesResource;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListTicketFilesController extends AbstractAPIController
{
    private TicketRepositoryInterface $ticketRepository;

    public function __construct(
        TicketRepositoryInterface $ticketRepository
    ) {
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(PaginationRequest $request, int $id): JsonResource
    {
        try {
            /** @var Ticket $ticket */
            $ticket = $this->ticketRepository->findWithFileVersions($id);

            if ($ticket === null) {
                return $this->respondNotFound([
                    'message' => 'Ticket not found.',
                ]);
            }

            return new TicketFilesResource(
                $ticket->clientTicketFiles()->paginate(
                    $request->getSize(),
                    ['*'],
                    null,
                    $request->getPageNumber(),
                )
            );
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage());
        }
    }
}
