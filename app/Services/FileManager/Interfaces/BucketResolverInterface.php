<?php

declare(strict_types=1);

namespace App\Services\FileManager\Interfaces;

interface BucketResolverInterface
{
    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNotFoundException
     */
    public function resolve(string $bucketName): mixed;
}
