<?php

declare(strict_types=1);

namespace App\Services\FileManager\Resolvers;

use App\Services\FileManager\Exceptions\BucketNotFoundException;
use App\Services\FileManager\Interfaces\BucketResolverInterface;
use App\Services\FileManager\Interfaces\StorageClientFactoryInterface;
use App\Services\FileManager\Bucket as BucketLocal;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Throwable;
use Illuminate\Contracts\Config\Repository;

final class BucketResolver implements BucketResolverInterface
{
    /**
     * @var string
     */
    private const CONFIG_KEY = 'filesystems.disks.file-uploads';

    private Repository $config;

    private StorageClient $storageClient;

    public function __construct(
        Repository $config,
        StorageClientFactoryInterface $storageClientFactory
    ) {
        $this->config = $config;
        $this->storageClient = $storageClientFactory->make();
    }

    /**
     * @param string $bucketName
     * @return mixed
     */
    public function resolve(string $bucketName): mixed
    {
        $config = $this->config->get(self::CONFIG_KEY);

        if (Arr::get($config, 'driver') === 's3') {
            return new BucketLocal(
                Arr::get($config, 'bucket'),
                Arr::get($config, 'driver')
            );
        }

        try {
            $bucket = $this->storageClient->bucket($bucketName);

            if ($bucket->exists() === false) {
                throw new BucketNotFoundException('Bucket not found.');
            }

            $url = Config::get('mail.client_url', null);

            $bucket->update([
                'cors' => [
                    [
                        'method' => ['GET', 'HEAD'],
                        'origin' => [$url],
                        'responseHeader' => ['Content-Type'],
                        'maxAgeSeconds' => '3600',
                    ]
                ]
            ]);

            return $bucket;
        } catch (Throwable $throwable) {
            return $this->storageClient->bucket('crm-api');
        }
    }
}
