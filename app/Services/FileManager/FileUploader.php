<?php

declare(strict_types=1);

namespace App\Services\FileManager;

use App\Jobs\File\UploadFileJob;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\FileManager\Interfaces\FileUploaderInterface;

final class FileUploader implements FileUploaderInterface
{
    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function upload(UploadFileResource $resource): void
    {
        $file = $resource->getFileModel();

        $fileObject = $resource->getFileObject();

        UploadFileJob::dispatch(
            $file->getId(),
            \base64_encode($fileObject->get())
        );
    }
}
