<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Libraries;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Libraries\CreateLibraryRequest;
use App\Http\Resources\API\Libraries\LibraryResource;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\Libraries\Interfaces\Factories\LibraryFactoryInterface;
use App\Services\Libraries\Interfaces\LibraryFileUploaderInterface;
use App\Services\Libraries\Resources\CreateLibraryResource;
use App\Services\Libraries\Resources\LibraryProcessResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreateLibraryController extends AbstractAPIController
{
    /**
     * @var string
     */
    public const INTERNAL_BUCKET = 'CRM-ADMIN';

    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private LibraryFactoryInterface $libraryFactory;

    private LibraryFileUploaderInterface $libraryFileUploader;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        LibraryFactoryInterface $libraryFactory,
        LibraryFileUploaderInterface $libraryFileUploader
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->libraryFactory = $libraryFactory;
        $this->libraryFileUploader = $libraryFileUploader;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\FileManager\Exceptions\BucketNotFoundException
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    public function __invoke(CreateLibraryRequest $request): JsonResource
    {
        /** @var \App\Models\User $user */
        $user = $this->getUser();
        $file = null;

        if ($request->getFile() === null && $request->getVideoLink() === null) {
            return $this->respondBadRequest([
                'message' => 'Either file or video link should be provided.',
            ]);
        }

        if ($request->getFile() !== null) {
            $bucket = $this->bucketFactory->make(self::INTERNAL_BUCKET);

            try {
                $file = $this->fileFactory->make(new CreateFileResource([
                    'uploadedFile' => $request->getFile(),
                    'disk' => $bucket->disk(),
                    'filePath' => 'libraries',
                    'uploadedBy' => $user,
                    'bucket' => $bucket->name(),
                ]));
            } catch (\Throwable $throwable) {
                return $this->respondInternalError([
                    'message' => $throwable->getMessage(),
                ]);
            }
        }

        try {
            $library = $this->libraryFactory->make(new CreateLibraryResource([
                'createdBy' => $user,
                'description' => $request->getDescription(),
                'title' => $request->getTitle(),
                'libraryCategoryId' => $request->getLibraryCategoryId(),
                'videoLink' => $request->getVideoLink(),
                'file' => $file,
            ]));

            if ($request->getFile() === null) {
                return new LibraryResource($library);
            }

            $this->libraryFileUploader->upload(new LibraryProcessResource([
                'file' => $file,
                'library' => $library,
                'uploadedFile' => $request->getFile(),
                'user' => $user
            ]));

            return new LibraryResource($library);
        } catch (\Throwable $throwable) {
            return $this->respondInternalError([
                'message' => $throwable->getMessage(),
            ]);
        }
    }
}
