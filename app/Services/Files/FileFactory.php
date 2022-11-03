<?php

declare(strict_types=1);

namespace App\Services\Files;

use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;

final class FileFactory implements FileFactoryInterface
{

    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository) {
        $this->fileRepository = $fileRepository;
    }

    public function make(CreateFileResource $resource): File
    {
        $uploadedFile = $resource->getUploadedFile();

        $filename = \pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);

        $regex = "/[^a-zA-Z0-9._ -]/";

        $originalFileName = preg_replace($regex, '', $uploadedFile->getClientOriginalName());

        $originalFileName = str_replace(' ', '', $originalFileName);

        $generatedFilename =  \sprintf(
            '%s-%s',
            \sha1(\sprintf('%s%s', $filename, time())),
            $originalFileName
        );

        /** @var \App\Models\File $file */
        $file = $this->fileRepository->create([
            'original_filename' => $uploadedFile->getClientOriginalName(),
            'file_name' => $generatedFilename,
            'file_size' => $uploadedFile->getSize(),
            'file_path' => $resource->getFilePath() ?? '',
            'file_extension' => $resource->getFileExtension() ?? '',
            'file_type' => $uploadedFile->getClientMimeType(),
            'folder_id' => $resource->getFolder()?->getId(),
            'uploaded_by' => $resource->getUploadedBy()->getId(),
            'deleted_by' => $resource->getDeletedBy()?->getId(),
            'disk' => $resource->getDisk(),
            'bucket' => $resource->getBucket(),
        ]);

        return $file;
    }
}
