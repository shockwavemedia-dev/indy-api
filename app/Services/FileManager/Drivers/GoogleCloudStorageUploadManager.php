<?php

declare(strict_types=1);

namespace App\Services\FileManager\Drivers;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileManager\Interfaces\BucketResolverInterface;
use App\Services\FileManager\Interfaces\FileUploadManagerResolverInterface;
use Carbon\Carbon;
use Rolandstarke\Thumbnail\Facades\Thumbnail;
use Sentry\Severity;
use Throwable;

final class GoogleCloudStorageUploadManager extends AbstractFileManager implements FileUploadManagerResolverInterface
{
    private BucketResolverInterface $bucketResolver;

    public function __construct(
        BucketResolverInterface $bucketResolver,
        FileRepositoryInterface $fileRepository,
        ErrorLogInterface $sentryHandler
    ) {
        parent::__construct($fileRepository, $sentryHandler);

        $this->bucketResolver = $bucketResolver;
    }

    public function upload(File $file, ?string $rawFile = null): void
    {
        try {
            if ($rawFile === null) {
                $this->sentryHandler->log('empty file');

                return;
            }

            $localFile = base64_decode($rawFile);

            $path = null;

            if ($file->getFilePath() !== '' && $file->getFilePath() !== null) {
                $path = sprintf('%s/', $file->getFilePath());
            }

            $filepath = sprintf(
                '%s%s',
                $path,
                $file->getFileName()
            );

            $bucket = $this->bucketResolver->resolve($file->getBucket());

            $storageObject = $bucket->upload($localFile, [
                'name' => $filepath,
            ]);

            $expiry = (new Carbon())->addMinutes(self::MINUTES_EXPIRY);

            $signedUrl = $storageObject->signedUrl($expiry);

            $this->fileRepository->updateSignedUrl(
                $file,
                $signedUrl,
                $expiry
            );

            $file->refresh();

            $thumbnail = Thumbnail::src($signedUrl)->crop(80, 80);

            $thumbnailObject = $bucket->upload(
                $thumbnail->string(),
                [
                    'name' => sprintf(
                        '%s-%s',
                        'thumbnail',
                        $file->getFileName()
                    ),
                ]
            );

            $this->fileRepository->updateThumbnailUrl($file, $thumbnailObject->signedUrl($expiry));

            $this->sentryHandler->log(
                sprintf('%s has been uploaded', $filepath),
                Severity::info()
            );
        } catch (Throwable $exception) {
            $this->sentryHandler->reportError($exception);
        }
    }

    public function supports(string $driver): bool
    {
        return $driver === 'gcs';
    }
}
