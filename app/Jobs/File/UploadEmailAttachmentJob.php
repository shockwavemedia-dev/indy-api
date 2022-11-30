<?php

declare(strict_types=1);

namespace App\Jobs\File;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileManager\Interfaces\S3ClientFactoryInterface;
use App\Services\FileManager\Interfaces\S3SignedUrlServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

final class UploadEmailAttachmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private int $fileId,
        private string $rawFile
    ) {
    }

    public function handle(
        ErrorLogInterface $sentryHandler,
        FileRepositoryInterface $fileRepository,
        S3ClientFactoryInterface $s3ClientFactory,
        S3SignedUrlServiceInterface $s3SignedUrlService
    ): void {
        try {
            $s3Client = $s3ClientFactory->make();

            /** @var File $file */
            $file = $fileRepository->find($this->fileId);

            $path = null;

            if ($file->getFilePath() !== '' && $file->getFilePath() !== null) {
                $path = sprintf('%s/', $file->getFilePath());
            }

            $filepath = sprintf(
                '%s%s',
                $path,
                $file->getFileName()
            );

            $s3Client->upload(
                'indy-app',
                $filepath,
                base64_decode($this->rawFile),
                'private',
            );

            $s3SignedUrlService->upload($file);
        } catch (Throwable $exception) {
            $sentryHandler->reportError($exception);
        }
    }
}
