<?php

declare(strict_types=1);

namespace App\Services\FileManager;

use App\Services\FileManager\Interfaces\BucketFactoryInterface;

abstract class AbstractFileManager
{
    protected Bucket $bucket;

    private BucketFactoryInterface $bucketFactory;

    public function __construct(BucketFactoryInterface $bucketFactory)
    {
        $this->bucketFactory = $bucketFactory;
    }

    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    protected function resolveBucket(string $bucketName): void
    {
        $this->bucket = $this->bucketFactory->make($bucketName);
    }
}
