<?php

namespace App\Services\FileManager\Interfaces;

use App\Services\FileManager\Exceptions\FileManagerDriverNotFoundException;

interface FileUploadDriverFactoryInterface
{
    /**
     * @throws FileManagerDriverNotFoundException
     */
    public function make(string $manager): FileUploadManagerResolverInterface;
}
