<?php

declare(strict_types=1);

namespace App\Services\FileFeedbacks;

use App\Models\File;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\FileFeedback;
use App\Models\User;
use App\Services\FileFeedbacks\Interfaces\FeedbackAttachmentFactoryInterface;
use App\Services\FileFeedbacks\Interfaces\ProcessFeedbackAttachmentUploadInterface;
use App\Services\FileFeedbacks\Resources\CreateFeedbackAttachmentResource;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use Illuminate\Http\UploadedFile;

final class ProcessFeedbackAttachmentUpload implements ProcessFeedbackAttachmentUploadInterface
{
    private FileUploaderInterface $fileUploader;

    private FeedbackAttachmentFactoryInterface $feedbackAttachment;

    public function __construct(
        FileUploaderInterface $fileUploader,
        FeedbackAttachmentFactoryInterface $feedbackAttachment,
    ) {
        $this->fileUploader = $fileUploader;
        $this->feedbackAttachment = $feedbackAttachment;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function process(
        File $file,
        User $user,
        FileFeedback $fileFeedback,
        ClientTicketFile $clientTicketFile,
        UploadedFile $uploadedFile
    ): void {
        $this->feedbackAttachment->make(new CreateFeedbackAttachmentResource([
            'file' => $file,
            'fileFeedback' => $fileFeedback,
            'clientTicketFile' => $clientTicketFile,
        ]));

        $this->fileUploader->upload(new UploadFileResource([
            'fileObject' => $uploadedFile,
            'fileModel' => $file,
        ]));
    }
}
