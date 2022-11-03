<?php

namespace App\Services\FileManager\Interfaces;

use App\Models\File;

interface S3SignedUrlServiceInterface
{
    public function upload(File $file): void;
}
