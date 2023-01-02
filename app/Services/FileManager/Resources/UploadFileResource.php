<?php

declare(strict_types=1);

namespace App\Services\FileManager\Resources;

use App\Models\File;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class UploadFileResource extends DataTransferObject
{
    public File $fileModel;

    public UploadedFile $fileObject;

    public function getFileModel(): File
    {
        return $this->fileModel;
    }

    public function getFileObject(): UploadedFile
    {
        return $this->fileObject;
    }

    public function setFileModel(File $fileModel): self
    {
        $this->fileModel = $fileModel;

        return $this;
    }

    public function setFileObject(UploadedFile $fileObject): self
    {
        $this->fileObject = $fileObject;

        return $this;
    }
}
