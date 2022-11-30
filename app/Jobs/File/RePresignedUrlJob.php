<?php

declare(strict_types=1);

namespace App\Jobs\File;

use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileManager\Interfaces\S3SignedUrlServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class RePresignedUrlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $fileId;

    private int $userId;

    public function __construct(int $fileId)
    {
        $this->fileId = $fileId;
    }

    public function handle(
        FileRepositoryInterface $fileRepository,
        S3SignedUrlServiceInterface $s3SignedUrlService

    ): void {
        /** @var File $file */
        $file = $fileRepository->find($this->fileId);

        $s3SignedUrlService->upload($file);
    }
}
