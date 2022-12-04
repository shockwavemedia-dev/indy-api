<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\TicketFiles;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\TicketFiles\FileVersionResource;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListTicketFileVersionsController extends AbstractAPIController
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository
    ) {
        $this->ticketRepository = $ticketRepository;
    }

    public function __invoke(int $ticketId): JsonResource
    {
        /** @var Ticket $ticket */
        $ticket = $this->ticketRepository->findWithFileVersions($ticketId);

        if ($ticket === null) {
            return $this->respondNotFound([
                'message' => 'Ticket not found.',
            ]);
        }

        $fileVersions = [];

        /** @var ClientTicketFile $ticketFile */
        foreach ($ticket->getClientTicketFiles() as $ticketFile) {
            foreach ($ticketFile->getFileVersions() as $fileVersion) {
                $fileVersions[] = new FileVersionResource($fileVersion);
            }
        }

        return new JsonResource($fileVersions);
    }
}
