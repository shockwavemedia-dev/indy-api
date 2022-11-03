<?php

declare(strict_types=1);

namespace App\Services\FileManager\Interfaces;

use App\Services\FileManager\Resources\UploadFileResource;

interface FileUploaderInterface
{
    public function upload(UploadFileResource $resource): void;
}
