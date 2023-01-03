<?php

declare(strict_types=1);

namespace App\Services\EventsService\Resolvers;

use App\Models\Event;
use App\Models\User;
use App\Services\EventsService\Interfaces\FilesUploadResolverInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;

final class FilesUploadResolver implements FilesUploadResolverInterface
{
    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private FileUploaderInterface $fileUploader;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        FileUploaderInterface $fileUploader
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(Event $event, User $user, array $files): void
    {
        $bucket = $this->bucketFactory->make($event->getClient()->getClientCode());

        foreach ($files as $file) {
            $fileModel = $this->fileFactory->make(new CreateFileResource([
                'uploadedFile' => $file,
                'disk' => $bucket->disk(),
                'filePath' => '',
                'folder' => $event->getFolder(),
                'uploadedBy' => $user,
                'bucket' => $bucket->name(),
            ]));

            $this->fileUploader->upload(new UploadFileResource([
                'fileModel' => $fileModel,
                'fileObject' => $file,
            ]));
        }
    }
}
