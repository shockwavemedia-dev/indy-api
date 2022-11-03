<?php

declare(strict_types=1);

namespace App\Services\FileFeedbacks;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\Client;
use App\Models\Tickets\FileFeedback;
use App\Models\User;
use App\Repositories\Interfaces\FileFeedbackAttachmentRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileFeedbacks\Interfaces\DeleteFeedbackAttachmentsInterface;
use App\Services\FileManager\Interfaces\FileRemoverInterface;

final class DeleteFeedbackAttachments implements DeleteFeedbackAttachmentsInterface
{
    private FileFeedbackAttachmentRepositoryInterface $fileFeedbackAttachmentRepository;

    private FileRemoverInterface $fileRemover;

    private FileRepositoryInterface $fileRepository;

    private ErrorLogInterface $sentryHandler;

    public function __construct(
        FileFeedbackAttachmentRepositoryInterface $fileFeedbackAttachmentRepository,
        FileRemoverInterface $fileRemover,
        FileRepositoryInterface $fileRepository,
        ErrorLogInterface $sentryHandler
    ) {
        $this->fileFeedbackAttachmentRepository = $fileFeedbackAttachmentRepository;
        $this->fileRemover = $fileRemover;
        $this->fileRepository = $fileRepository;
        $this->sentryHandler = $sentryHandler;
    }

    public function deleteByFeedback(FileFeedback $feedback, User $user, Client $client): void
    {
        $attachments = $feedback->getFeedbackAttachments();

        foreach($attachments as $attachment) {
            $file = $attachment->getFile();

            $this->fileFeedbackAttachmentRepository->deleteFeedbackAttachment($attachment);

            $this->fileRepository->deleteFile($file, $user);

            $this->fileRemover->delete($file, $user);

            $this->sentryHandler->log(\sprintf(
                'File id %s has been deleted.',
                $file->getId()
            ));
        }
    }
}
