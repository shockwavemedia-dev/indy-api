<?php

declare(strict_types=1);

namespace App\Services\FileManager\Drivers;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileManager\Interfaces\FileUploadManagerResolverInterface;
use App\Services\FileManager\Interfaces\S3ClientFactoryInterface;
use App\Services\FileManager\Interfaces\S3SignedUrlServiceInterface;

final class S3FileUploadManager extends AbstractFileManager implements FileUploadManagerResolverInterface
{
    /**
     * @var string
     */
    private const CONFIG_KEY = 'filesystems.disks.s3-file-uploads';

    private S3ClientFactoryInterface $s3ClientFactory;

    private S3SignedUrlServiceInterface $s3SignedUrlService;

    public function __construct(
        ErrorLogInterface $sentryHandler,
        FileRepositoryInterface $fileRepository,
        S3ClientFactoryInterface $s3ClientFactory,
        S3SignedUrlServiceInterface $s3SignedUrlService,
    ) {
        $this->s3ClientFactory = $s3ClientFactory;
        $this->s3SignedUrlService = $s3SignedUrlService;

        parent::__construct($fileRepository, $sentryHandler);
    }

    public function upload(File $file, ?string $rawFile = null): void
    {
        try {
            $s3Client = $this->s3ClientFactory->make();

            $path = null;

            if ($file->getFilePath() !== '' && $file->getFilePath() !== null) {
                $path =  sprintf('%s/', $file->getFilePath());
            }

            $filepath = sprintf(
                '%s%s',
                $path,
                $file->getFileName()
            );

            $s3Client->upload(
                $file->getBucket(),
                $filepath,
                base64_decode($rawFile),
                'private',
            );

            $this->s3SignedUrlService->upload($file);
        } catch (\Exception $exception) {
            $this->sentryHandler->reportError($exception);
        }
    }

    public function supports(string $driver): bool
    {
        return $driver === 's3';
    }
}
