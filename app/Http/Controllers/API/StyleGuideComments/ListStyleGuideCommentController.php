<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\StyleGuideComments;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\StyleGuideComments\StyleGuideCommentsResource;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListStyleGuideCommentController extends AbstractAPIController
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository
    ) {
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(int $ticketId): JsonResource
    {
        /** @var Ticket $ticket */
        $ticket = $this->ticketRepository->find($ticketId);

        if ($ticket === null) {
            return $this->respondNotFound(['message' => 'Ticket not found']);
        }

        return new StyleGuideCommentsResource($ticket->getStyleGuideComments());
    }
}
