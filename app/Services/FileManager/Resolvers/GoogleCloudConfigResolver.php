<?php

declare(strict_types=1);

namespace App\Services\FileManager\Resolvers;

use App\Services\FileManager\Interfaces\GoogleCloudConfigResolverInterface;
use App\Services\FileManager\Resources\GoogleCloudConfigResource;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;

final class GoogleCloudConfigResolver implements GoogleCloudConfigResolverInterface
{
    /**
     * @var string
     */
    private const CONFIG_KEY = 'filesystems.disks.gcs';

    private Repository $configRepository;

    public function __construct(Repository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(): GoogleCloudConfigResource
    {
        $config = $this->configRepository->get(self::CONFIG_KEY, []);

        return new GoogleCloudConfigResource([
            'projectId' => Arr::get($config, 'project_id'),
            'keyFilePath' => Arr::get($config, 'key_file_path'),
        ]);
    }
}
