<?php

namespace App\Services\FileManager\Resolvers;

use App\Services\FileManager\Interfaces\FileManagerConfigResolverInterface;
use Illuminate\Contracts\Config\Repository;

final class FileManagerConfigResolver implements FileManagerConfigResolverInterface
{
    /**
     * @var string
     */
    private const CONFIG_KEY = 'filesystems.disks.file-uploads';

    private Repository $configRepository;

    public function __construct(Repository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function resolve(): array
    {
        return $this->configRepository->get(self::CONFIG_KEY, []);
    }
}
