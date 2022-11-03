<?php

declare(strict_types=1);

namespace App\Services\FileManager;

use App\Models\File;
use App\Models\User;
use App\Services\FileManager\Interfaces\FileManagerConfigResolverInterface;
use App\Services\FileManager\Interfaces\FileRemoverDriverFactoryInterface;
use App\Services\FileManager\Interfaces\FileRemoverInterface;

final class FileRemover implements FileRemoverInterface
{
    private FileManagerConfigResolverInterface $fileManagerConfigResolver;

    private FileRemoverDriverFactoryInterface $fileRemoverDriverFactory;

    public function __construct(
        FileManagerConfigResolverInterface $fileManagerConfigResolver,
        FileRemoverDriverFactoryInterface  $fileRemoverDriverFactory,
    ) {
        $this->fileManagerConfigResolver = $fileManagerConfigResolver;
        $this->fileRemoverDriverFactory = $fileRemoverDriverFactory;
    }

    /**
     * @throws Exceptions\BucketNameExistsException
     * @throws Exceptions\FileManagerDriverNotFoundException
     */
    public function delete(File $file, User $user): void
    {
        $config = $this->fileManagerConfigResolver->resolve();

        $fileManager = $this->fileRemoverDriverFactory->make($config['driver']);

        $fileManager->remove($file, $user);
    }
}
