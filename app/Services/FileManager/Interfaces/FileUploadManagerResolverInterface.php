<?php

namespace App\Services\FileManager\Interfaces;

use App\Models\File;

interface FileUploadManagerResolverInterface
{
    public function upload(File $file, ?string $rawFile = null): void;

    public function supports(string $driver): bool;
}
