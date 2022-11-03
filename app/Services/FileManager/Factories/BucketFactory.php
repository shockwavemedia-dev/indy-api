<?php

declare(strict_types=1);

namespace App\Services\FileManager\Factories;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Services\FileManager\Bucket as BucketLocal;
use App\Services\FileManager\Exceptions\BucketNotFoundException;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\FileManager\Interfaces\BucketResolverInterface;
use App\Services\FileManager\Interfaces\FileManagerConfigResolverInterface;
use App\Services\FileManager\Interfaces\StorageClientFactoryInterface;
use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Core\Exception\GoogleException;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\Connection\Rest;
use Illuminate\Support\Arr;

final class BucketFactory implements BucketFactoryInterface
{
    protected const LOGGER_KEY = "%s-client";

    private BucketResolverInterface $bucketResolver;

    private FileManagerConfigResolverInterface $fileManagerConfigResolver;

    private ErrorLogInterface $sentryHandler;

    private StorageClientFactoryInterface $storageClientFactory;

    public function __construct(
        BucketResolverInterface            $bucketResolver,
        FileManagerConfigResolverInterface $fileManagerConfigResolver,
        ErrorLogInterface                  $sentryHandler,
        StorageClientFactoryInterface      $storageClientFactory
    ) {
        $this->bucketResolver = $bucketResolver;
        $this->fileManagerConfigResolver = $fileManagerConfigResolver;
        $this->sentryHandler = $sentryHandler;
        $this->storageClientFactory = $storageClientFactory;
    }

    /**
     * @throws \Google\Cloud\Core\Exception\ConflictException
     * @throws \Google\Cloud\Core\Exception\GoogleException
     */
    public function make(string $bucketName): BucketLocal
    {
        $bucketName = strtolower(sprintf(self::LOGGER_KEY, $bucketName));

        $config = $this->fileManagerConfigResolver->resolve();

        if (Arr::get($config, 'driver') === 'local') {
            $bucket = new Bucket(new Rest([]), $bucketName);

            return new BucketLocal($bucket->name(), 'gcs');
        }

        if (Arr::get($config, 'driver') === 's3') {
            return new BucketLocal(
                Arr::get($config, 'bucket'),
                Arr::get($config, 'driver')
            );
        }

        try {
            $bucket = $this->bucketResolver->resolve($bucketName);
        } catch (BucketNotFoundException $e) {
            //ignore exception proceed on creation
        }

        try {
            $storageClient = $this->storageClientFactory->make();

            $bucket = $storageClient->createBucket($bucketName);

            return new BucketLocal($bucket->name(), 'gcs');
        } catch (ConflictException|GoogleException $exception) {
            $this->sentryHandler->reportError($exception);

            throw $exception;
        }
    }
}
