<?php

declare(strict_types=1);

namespace App\Services\FileManager\Factories;

use App\Services\FileManager\Interfaces\GoogleCloudConfigResolverInterface;
use App\Services\FileManager\Interfaces\StorageClientFactoryInterface;
use Google\Cloud\Storage\StorageClient;

final class StorageClientFactory implements StorageClientFactoryInterface
{
    private GoogleCloudConfigResolverInterface $configResolver;

    public function __construct(GoogleCloudConfigResolverInterface $configResolver)
    {
        $this->configResolver = $configResolver;
    }

    public function make(): StorageClient
    {
        $config = $this->configResolver->resolve();

        return new StorageClient([
            'projectId' => $config->getProjectId(),
            'keyFilePath' => $config->getKeyFilePath(),
        ]);
    }
}
