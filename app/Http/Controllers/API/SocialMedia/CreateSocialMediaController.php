<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\SocialMedia\CreateSocialMediaRequest;
use App\Http\Resources\API\SocialMedia\SocialMediaResource;
use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\SocialMedia\Interfaces\SocialMediaAttachmentFactoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaFactoryInterface;
use App\Services\SocialMedia\Resources\CreateAttachmentResource;
use App\Services\SocialMedia\Resources\CreateSocialMediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreateSocialMediaController extends AbstractAPIController
{
    private BucketFactoryInterface $bucketFactory;

    private ClientRepositoryInterface $clientRepository;

    private FileFactoryInterface $fileFactory;

    private FileRepositoryInterface $fileRepository;

    private FileUploaderInterface $fileUploader;

    private SocialMediaFactoryInterface $socialMediaFactory;

    private SocialMediaAttachmentFactoryInterface $socialMediaAttachmentFactory;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        ClientRepositoryInterface $clientRepository,
        FileFactoryInterface $fileFactory,
        FileRepositoryInterface $fileRepository,
        FileUploaderInterface $fileUploader,
        SocialMediaFactoryInterface $socialMediaFactory,
        SocialMediaAttachmentFactoryInterface $socialMediaAttachmentFactory
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->clientRepository = $clientRepository;
        $this->fileFactory = $fileFactory;
        $this->fileRepository = $fileRepository;
        $this->fileUploader = $fileUploader;
        $this->socialMediaFactory = $socialMediaFactory;
        $this->socialMediaAttachmentFactory = $socialMediaAttachmentFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    public function __invoke(CreateSocialMediaRequest $request, int $id): JsonResource
    {
        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        if (
            $this->getUser()->getUserType()->getType()->getValue() !== UserTypeEnum::ADMIN &&
            $client->getId() !== $this->getUser()->getUserType()->getClient()->getId()
        ) {
            return $this->respondForbidden();
        }

        $socialMedia = $this->socialMediaFactory->make(new CreateSocialMediaResource([
            'campaignType' => $request->getCampaignType(),
            'post' => $request->getPost(),
            'copy' => $request->getCopy(),
            'status' => $request->getStatus(),
            'client' => $client,
            'channels' => $request->getChannels(),
            'notes' => $request->getNotes(),
            'postDate' => $request->getPostDate(),
            'createdBy' => $this->getUser(),
        ]));

        if ($request->getAttachments() === null) {
            return new SocialMediaResource($socialMedia);
        }

        $bucket = $this->bucketFactory->make($client->getClientCode());

        foreach ($request->getAttachments() as $attachment) {
            $fileModel = $this->fileFactory->make(new CreateFileResource([
                'uploadedFile' => $attachment,
                'disk' => $bucket->disk(),
                'filePath' => sprintf('social-media/%s', $socialMedia->getId()),
                'folder' => null,
                'uploadedBy' => $this->getUser(),
                'bucket' => $bucket->name(),
            ]));

            $this->socialMediaAttachmentFactory->make(new CreateAttachmentResource([
                'socialMedia' => $socialMedia,
                'file' => $fileModel,
            ]));

            $this->fileUploader->upload(new UploadFileResource([
                'fileModel' => $fileModel,
                'fileObject' => $attachment,
            ]));
        }

        if (count($request->getFileIds() ?? []) > 0) {
            $files = $this->fileRepository->findByIds($request->getFileIds());

            foreach ($files as $file) {
                $this->socialMediaAttachmentFactory->make(new CreateAttachmentResource([
                    'socialMedia' => $socialMedia,
                    'file' => $file,
                ]));
            }
        }

        return new SocialMediaResource($socialMedia);
    }
}
