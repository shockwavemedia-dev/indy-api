<?php

declare(strict_types=1);

namespace App\Services\FileManager\Interfaces;

use Google\Cloud\Storage\StorageClient;

interface StorageClientFactoryInterface
{
    public function make(): StorageClient;
}
