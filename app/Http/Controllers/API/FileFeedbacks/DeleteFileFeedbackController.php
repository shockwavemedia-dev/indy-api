<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\FileFeedbacks;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\FileFeedbackRepositoryInterface;
use App\Services\FileFeedbacks\Interfaces\DeleteFeedbackAttachmentsInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class DeleteFileFeedbackController extends AbstractAPIController
{
    private DeleteFeedbackAttachmentsInterface $deleteFeedbackAttachments;

    private FileFeedbackRepositoryInterface $fileFeedbackRepository;

    private ErrorLogInterface $sentryHandler;

    public function __construct(
        DeleteFeedbackAttachmentsInterface $deleteFeedbackAttachments,
        FileFeedbackRepositoryInterface $fileFeedbackRepository,
        ErrorLogInterface $sentryHandler
    ) {
        $this->deleteFeedbackAttachments = $deleteFeedbackAttachments;
        $this->fileFeedbackRepository = $fileFeedbackRepository;
        $this->sentryHandler = $sentryHandler;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var \App\Models\Tickets\FileFeedback $fileFeedback */
        $fileFeedback = $this->fileFeedbackRepository->find($id);

        if ($fileFeedback === null) {
            return $this->respondNoContent();
        }

        /** @var \App\Models\User $user */
        $user = $this->getUser();

        try {
            $this->fileFeedbackRepository->deleteFileFeedback($fileFeedback);

            $attachments = $fileFeedback->getFeedbackAttachments();

            if (\count($attachments) === 0) {
                return $this->respondNoContent();
            }

            /** @var \App\Models\Client $client */
            $client = $fileFeedback->getClientTicketFile()->getClient();

            $this->deleteFeedbackAttachments->deleteByFeedback($fileFeedback, $user, $client);

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            $this->sentryHandler->reportError($throwable);
            return $this->respondNoContent();
        }
    }
}
