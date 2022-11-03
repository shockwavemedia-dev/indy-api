<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Libraries;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Libraries\UpdateLibraryRequest;
use App\Http\Resources\API\Libraries\LibraryResource;
use App\Repositories\Interfaces\LibraryCategoryRepositoryInterface;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use App\Services\Libraries\Interfaces\LibraryFileRemoverInterface;
use App\Services\Libraries\Interfaces\LibraryFileUploaderInterface;
use App\Services\Libraries\Resources\CreateLibraryResource;
use App\Services\Libraries\Resources\LibraryProcessResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdateLibraryController extends AbstractAPIController
{
    /**
     * @var string
     */
    public const INTERNAL_BUCKET = 'CRM-ADMIN';

    private BucketFactoryInterface $bucketFactory;

    private FileFactoryInterface $fileFactory;

    private LibraryCategoryRepositoryInterface $libraryCategoryRepository;

    private LibraryFileUploaderInterface $libraryFileUploader;

    private LibraryRepositoryInterface $libraryRepository;

    private LibraryFileRemoverInterface $libraryFileRemover;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        FileFactoryInterface $fileFactory,
        LibraryCategoryRepositoryInterface $libraryCategoryRepository,
        LibraryRepositoryInterface $libraryRepository,
        LibraryFileRemoverInterface $libraryFileRemover,
        LibraryFileUploaderInterface $libraryFileUploader
    ) {
        $this->bucketFactory = $bucketFactory;
        $this->fileFactory = $fileFactory;
        $this->libraryCategoryRepository = $libraryCategoryRepository;
        $this->libraryFileRemover = $libraryFileRemover;
        $this->libraryFileUploader = $libraryFileUploader;
        $this->libraryRepository = $libraryRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(int $id, UpdateLibraryRequest $request): JsonResource
    {
        /** @var \App\Models\Library $library */
        $library = $this->libraryRepository->find($id);

        if ($library === null) {
            return $this->respondNotFound([
                'message' => 'Library not found.',
            ]);
        }

        /** @var \App\Models\User $user */
        $user = $this->getUser();
        $file = null;

        if ($request->getFile() !== null) {
            try {
                $bucket = $this->bucketFactory->make(self::INTERNAL_BUCKET);
                // Remove existing file since new file is provided
                $this->libraryFileRemover->delete($library->getFile());

                $file = $this->fileFactory->make(new CreateFileResource([
                    'uploadedFile' => $request->getFile(),
                    'disk' => $bucket->disk(), // Default to google cloud server driver
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
            $libraryCategory = $this->libraryCategoryRepository->find($request->getLibraryCategoryId());

            $library = $this->libraryRepository->update($library, new CreateLibraryResource([
                'createdBy' => $user,
                'updatedBy' => $user,
                'description' => $request->getDescription(),
                'title' => $request->getTitle() ?? $library->getTitle(),
                'libraryCategory' => $libraryCategory,
                'videLink' => $request->getVideoLink(),
                'file' => $file,
            ]));

            if ($file !== null) {
                $this->libraryFileUploader->upload(new LibraryProcessResource([
                    'file' => $file,
                    'library' => $library,
                    'uploadedFile' => $request->getFile(),
                    'user' => $user
                ]));
            }

            return new LibraryResource($library);
        }  catch (\Throwable $throwable) {
            return $this->respondInternalError([
                'message' => $throwable->getMessage(),
            ]);
        }
    }
}
