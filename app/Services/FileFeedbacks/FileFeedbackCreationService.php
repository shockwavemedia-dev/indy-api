<?php

declare(strict_types=1);

namespace App\Services\FileFeedbacks;

use App\Models\Tickets\FileFeedback;
use App\Repositories\Interfaces\FileFeedbackRepositoryInterface;
use App\Services\FileFeedbacks\Interfaces\FileFeedbackCreationServiceInterface;
use App\Services\FileFeedbacks\Resources\CreateFileFeedbackResource;

final class FileFeedbackCreationService implements FileFeedbackCreationServiceInterface
{
    private FileFeedbackRepositoryInterface $fileFeedbackRepository;

    public function __construct(
        FileFeedbackRepositoryInterface $fileFeedbackRepository,
    ) {
        $this->fileFeedbackRepository = $fileFeedbackRepository;
    }

    public function create(CreateFileFeedbackResource $resource): FileFeedback
    {
        /** @var FileFeedback $feedback */
        $feedback = $this->fileFeedbackRepository->create([
            'client_file_id' => $resource->getClientTicketFile(),
            'feedback_by' => $resource->getFeedbackBy(),
            'feedback_by_type' => $resource->getFeedbackByType(),
            'feedback' => $resource->getFeedback()
        ]);

        return $feedback;
    }

}
