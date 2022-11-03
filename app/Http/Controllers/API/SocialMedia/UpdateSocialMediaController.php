<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\SocialMedia\UpdateSocialMediaRequest;
use App\Http\Resources\API\SocialMedia\SocialMediaResource;
use App\Models\SocialMedia;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\SocialMedia\Interfaces\SocialMediaAttachmentFactoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaUpdateResolverInterface;
use App\Services\SocialMedia\Resources\CreateAttachmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdateSocialMediaController extends AbstractAPIController
{
    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private FileRepositoryInterface $fileRepository;

    private FileUploaderInterface $fileUploader;

    private SocialMediaAttachmentFactoryInterface $socialMediaAttachmentFactory;

    private SocialMediaRepositoryInterface $socialMediaRepository;

    private SocialMediaUpdateResolverInterface $socialMediaUpdateResolver;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        FileRepositoryInterface $fileRepository,
        FileUploaderInterface $fileUploader,
        SocialMediaAttachmentFactoryInterface $socialMediaAttachmentFactory,
        SocialMediaRepositoryInterface $socialMediaRepository,
        SocialMediaUpdateResolverInterface $socialMediaUpdateResolver
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->fileRepository = $fileRepository;
        $this->fileUploader = $fileUploader;
        $this->socialMediaAttachmentFactory = $socialMediaAttachmentFactory;
        $this->socialMediaRepository = $socialMediaRepository;
        $this->socialMediaUpdateResolver = $socialMediaUpdateResolver;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    public function __invoke(UpdateSocialMediaRequest $request, int $id): JsonResource
    {
        /** @var SocialMedia $socialMedia */
        $socialMedia = $this->socialMediaRepository->find($id);

        if ($socialMedia === null) {
            return $this->respondNotFound([
                'message' => 'Social Media not found',
            ]);
        }

        if (
            $this->getUser()->getUserType()->getType()->getValue() !== UserTypeEnum::ADMIN &&
            $socialMedia->getClient()->getId() !== $this->getUser()->getUserType()->getClient()->getId()
        ) {
            return $this->respondForbidden();
        }

        $socialMedia = $this->socialMediaUpdateResolver->update($socialMedia, $request->all([
            'post',
            'copy',
            'status',
            'channels',
            'notes',
            'post_date',
            'campaign_type',
        ]));

        if ($request->getAttachments() !== null) {
            $bucket = $this->bucketFactory->make($socialMedia->getClient()->getClientCode());

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
