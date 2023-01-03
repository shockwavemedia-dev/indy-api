<?php

declare(strict_types=1);

namespace App\Services\Libraries;

use App\Jobs\File\UploadFileJob;
use App\Services\Libraries\Interfaces\LibraryFileUploaderInterface;
use App\Services\Libraries\Resources\LibraryProcessResource;

final class LibraryFileUploader implements LibraryFileUploaderInterface
{
    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function upload(LibraryProcessResource $resource): void
    {
        $uploadedFile = $resource->getUploadedFile();

        $fileModel = $resource->getFile();

        $uploadedFile->storeAs(
            'temporary',
            $fileModel->getFilename()
        );

        UploadFileJob::dispatch(
            $fileModel->getId(),
            \base64_encode($uploadedFile->get()),
        );
    }
}
