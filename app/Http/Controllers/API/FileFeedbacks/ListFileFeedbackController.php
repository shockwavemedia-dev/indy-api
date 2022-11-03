<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\FileFeedbacks;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\FileFeedbacks\FileFeedbacksResource;
use App\Repositories\Interfaces\FileFeedbackRepositoryInterface;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListFileFeedbackController extends AbstractAPIController
{
    private ClientTicketFileRepositoryInterface $clientTicketFileRepository;

    private FileFeedbackRepositoryInterface $fileFeedbackRepository;

    public function __construct(
        ClientTicketFileRepositoryInterface $clientTicketFileRepository,
        FileFeedbackRepositoryInterface $fileFeedbackRepository
    ) {
        $this->clientTicketFileRepository = $clientTicketFileRepository;
        $this->fileFeedbackRepository = $fileFeedbackRepository;
    }

    public function __invoke(PaginationRequest $request, int $id): JsonResource
    {
        /** @var \App\Models\Tickets\ClientTicketFile $clientTicketFile */
        $clientTicketFile = $this->clientTicketFileRepository->find($id);

        if ($clientTicketFile === null) {
            return $this->respondNotFound([
                'message' => 'Client Ticket file not found.',
            ]);
        }

        try {
            $fileFeedback = $this->fileFeedbackRepository->findByClientTicketFile(
                $clientTicketFile,
                $request->getSize(),
                $request->getPageNumber()
            );

            return new FileFeedbacksResource($fileFeedback);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
