<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\FileFeedbacks;

use App\Enum\BackendUserNotificationTypeEnum;
use App\Enum\ClientNotificationTypeEnum;
use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\FileFeedbacks\CreateFileFeedbackRequest;
use App\Http\Resources\API\FileFeedbacks\FileFeedbackResource;
use App\Repositories\Interfaces\ClientTicketFileRepositoryInterface;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverFactoryInterface;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverFactoryInterface;
use App\Services\FileFeedbacks\Interfaces\FileFeedbackCreationServiceInterface;
use App\Services\FileFeedbacks\Interfaces\ProcessFeedbackAttachmentUploadInterface;
use App\Services\FileFeedbacks\Resources\CreateFileFeedbackResource;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateFileFeedbackController extends AbstractAPIController
{
    private BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory;

    private BucketFactoryInterface $bucketFactory;

    private ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory;

    private ClientTicketFileRepositoryInterface $clientTicketFileRepository;

    private FileFeedbackCreationServiceInterface $fileFeedbackCreationService;

    private ProcessFeedbackAttachmentUploadInterface $processFeedbackAttachmentUploadInterface;

    private FileFactoryInterface $fileFactory;

    public function __construct(
        BackendUserNotificationResolverFactoryInterface $backendUserNotificationResolverFactory,
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory,
        ClientTicketFileRepositoryInterface $clientTicketFileRepository,
        FileFeedbackCreationServiceInterface $fileFeedbackCreationService,
        ProcessFeedbackAttachmentUploadInterface $processFeedbackAttachmentUploadInterface,
    ) {
        $this->backendUserNotificationResolverFactory = $backendUserNotificationResolverFactory;
        $this->bucketFactory = $bucketFactory;
        $this->clientNotificationResolverFactory = $clientNotificationResolverFactory;
        $this->clientTicketFileRepository = $clientTicketFileRepository;
        $this->fileFactory = $fileFactory;
        $this->fileFeedbackCreationService = $fileFeedbackCreationService;
        $this->processFeedbackAttachmentUploadInterface = $processFeedbackAttachmentUploadInterface;
    }

    public function __invoke(CreateFileFeedbackRequest $request, int $id): JsonResource
    {
        try {
            /** @var \App\Models\Tickets\ClientTicketFile $clientTicketFile */
            $clientTicketFile = $this->clientTicketFileRepository->find($id);

            if ($clientTicketFile === null) {
                return $this->respondNotFound([
                    'message' => 'Client Ticket file not found.',
                ]);
            }

            $fileFeedback = $this->fileFeedbackCreationService->create(new CreateFileFeedbackResource([
                'clientTicketFile' => $clientTicketFile->getId(),
                'feedbackBy' => $this->getUser()->getId(),
                'feedbackByType' => $this->getUser()->getUserType()->getType()->getValue(),
                'feedback' => $request->getFeedback(),
            ]));

            /** @var \App\Models\User $user */
            $user = $this->getUser();

            $files = $request->getAttachments();

            $notificationResolver = null;

            // @TODO convert to factory pattern instead of if conditions
            if ($this->getUser()->getUserType()->getType()->getValue() === UserTypeEnum::ADMIN) {
                $notificationResolver = $this->clientNotificationResolverFactory->make(
                    new ClientNotificationTypeEnum(ClientNotificationTypeEnum::FILE_FEEDBACK)
                );
            }

            if ($this->getUser()->getUserType()->getType()->getValue() === UserTypeEnum::CLIENT) {
                $notificationResolver = $this->backendUserNotificationResolverFactory->make(
                    new BackendUserNotificationTypeEnum(BackendUserNotificationTypeEnum::FILE_FEEDBACK),
                );
            }

            $notificationResolver->resolve($fileFeedback);

            if (\count($files) === 0) {
                return new FileFeedbackResource($fileFeedback);
            }

            $client = $clientTicketFile->getClient();

            $bucket = $this->bucketFactory->make($client->getClientCode());

            foreach ($files as $file) {
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
                    $clientTicketFile,
                    $file
                );
            }

            return new FileFeedbackResource($fileFeedback);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
