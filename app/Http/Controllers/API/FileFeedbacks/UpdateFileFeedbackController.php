<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\FileFeedbacks;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\FileFeedbacks\UpdateFileFeedbackRequest;
use App\Http\Resources\API\FileFeedbacks\FileFeedbackResource;
use App\Repositories\Interfaces\FileFeedbackRepositoryInterface;
use App\Services\FileFeedbacks\Interfaces\DeleteFeedbackAttachmentsInterface;
use App\Services\FileFeedbacks\Resources\UpdateFileFeedbackResource;
use App\Services\FileFeedbacks\Interfaces\ProcessFeedbackAttachmentUploadInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UpdateFileFeedbackController extends AbstractAPIController
{
    private BucketFactoryInterface $bucketFactory;

    private DeleteFeedbackAttachmentsInterface $deleteFeedbackAttachments;

    private FileFeedbackRepositoryInterface $fileFeedbackRepository;

    private ProcessFeedbackAttachmentUploadInterface $processFeedbackAttachmentUploadInterface;

    private FileFactoryInterface $fileFactory;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        DeleteFeedbackAttachmentsInterface $deleteFeedbackAttachments,
        FileFeedbackRepositoryInterface $fileFeedbackRepository,
        ProcessFeedbackAttachmentUploadInterface $processFeedbackAttachmentUploadInterface
    ) {
        $this->fileFactory = $fileFactory;
        $this->bucketFactory = $bucketFactory;
        $this->deleteFeedbackAttachments = $deleteFeedbackAttachments;
        $this->fileFeedbackRepository = $fileFeedbackRepository;
        $this->processFeedbackAttachmentUploadInterface = $processFeedbackAttachmentUploadInterface;
    }

    public function __invoke(UpdateFileFeedbackRequest $request, int $id): JsonResource
    {
        /** @var \App\Models\Tickets\FileFeedback $fileFeedback */
        $fileFeedback = $this->fileFeedbackRepository->find($id);

        if ($fileFeedback === null) {
            return $this->respondNotFound([
                'message' => 'Client Ticket File not found.',
            ]);
        }

        if ($this->getUser()->getId() !== $fileFeedback->getFeedbackById()) {
            return $this->respondNotFound([
                'message' => 'Access Denied',
            ]);
        }

        try {
            $fileFeedback = $this->fileFeedbackRepository->update($fileFeedback, new UpdateFileFeedbackResource([
                'feedback' => $request->getFeedback(),
            ]));

            /** @var \App\Models\User $user */
            $user = $this->getUser();

            $newFiles = $request->getAttachments();

            /** @var \App\Models\Client $client */
            $client = $fileFeedback->getClientTicketFile()->getClient();

            if(\count($newFiles) === 0) {
                return new FileFeedbackResource($fileFeedback);
            }

            $this->deleteFeedbackAttachments->deleteByFeedback($fileFeedback, $user, $client);

            $bucket = $this->bucketFactory->make($client->getClientCode());

            foreach ($newFiles as $file) {
                $fileModel = $this->fileFactory->make(new CreateFileResource([
                    'uploadedFile' => $file,
                    'disk' => $bucket->disk(), // Default to google cloud server driver
                    'filePath' => 'feedback-attachment',
                    'uploadedBy' => $user,
                    'bucket' => $bucket->name(),
                ]));

                $this->processFeedbackAttachmentUploadInterface->process(
                    $fileModel,
                    $user,
                    $fileFeedback,
                    $fileFeedback->getClientTicketFile(),
                    $file,
                );
            }

            return new FileFeedbackResource($fileFeedback);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
