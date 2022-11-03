<?php

declare(strict_types=1);

namespace App\Services\FileManager\Interfaces;

use App\Services\FileManager\Bucket;
use App\Services\FileManager\Exceptions\BucketNameExistsException;

interface BucketFactoryInterface
{
    /**
     * @throws BucketNameExistsException
     */
    public function make(string $bucketName): Bucket;
}
