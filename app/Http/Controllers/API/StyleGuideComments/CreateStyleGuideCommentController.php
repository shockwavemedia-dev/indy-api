<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\StyleGuideComments;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\StyleGuideComments\CreateStyleGuideCommentRequest;
use App\Http\Resources\API\StyleGuideComments\StyleGuideCommentResource;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\StyleGuideComments\Interfaces\StyleGuideCommentFactoryInterface;
use App\Services\StyleGuideComments\Resources\CreateStyleGuideCommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreateStyleGuideCommentController extends AbstractAPIController
{
    public function __construct(
        private TicketRepositoryInterface $ticketRepository,
        private StyleGuideCommentFactoryInterface $styleGuideCommentFactory
    ) {
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(CreateStyleGuideCommentRequest $request, int $ticketId): JsonResource
    {
        $ticket = $this->ticketRepository->find($ticketId);

        if ($ticket === null) {
            return $this->respondNotFound(['message' => 'Ticket not found']);
        }

        return new StyleGuideCommentResource($this->styleGuideCommentFactory->make(
            new CreateStyleGuideCommentResource([
                'ticket' => $ticket,
                'user' => $this->getUser(),
                'message' => $request->getMessage(),
            ]),
        ));
    }
}
