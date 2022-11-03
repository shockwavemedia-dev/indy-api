<?php

declare(strict_types=1);

namespace App\Services\FileFeedbacks;

use App\Models\Tickets\FileFeedbackAttachment;
use App\Repositories\Interfaces\FileFeedbackAttachmentRepositoryInterface;
use App\Services\FileFeedbacks\Interfaces\FeedbackAttachmentFactoryInterface;
use App\Services\FileFeedbacks\Resources\CreateFeedbackAttachmentResource;

final class FeedbackAttachmentFactory implements FeedbackAttachmentFactoryInterface
{
    private FileFeedbackAttachmentRepositoryInterface $feedbackAttachmentRepository;

    public function __construct(FileFeedbackAttachmentRepositoryInterface $feedbackAttachmentRepository) {
        $this->feedbackAttachmentRepository = $feedbackAttachmentRepository;
    }

    public function make(CreateFeedbackAttachmentResource $resource): FileFeedbackAttachment
    {
        /** @var FileFeedbackAttachment $feedbackAttachment */
        $feedbackAttachment = $this->feedbackAttachmentRepository->create([
            'file_id' => $resource->getFile()->getId(),
            'client_file_id' => $resource->getClientTicketFile()->getId(),
            'feedback_id' => $resource->getFileFeedback()->getId()
        ]);

        return $feedbackAttachment;
    }
}
