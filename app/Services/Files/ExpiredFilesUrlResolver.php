<?php

declare(strict_types=1);

namespace App\Services\Files;

use App\Jobs\File\RePresignedUrlJob;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\Files\Interfaces\ExpiredFilesUrlResolverInterface;

final class ExpiredFilesUrlResolver implements ExpiredFilesUrlResolverInterface
{
    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function resolve(): void
    {
        $files = $this->fileRepository->findAllExpired();

        foreach ($files as $file) {
            RePresignedUrlJob::dispatch($file->getId());
        }
    }
}
