<?php

declare(strict_types=1);

namespace App\Jobs\File;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileManager\Interfaces\S3ClientFactoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Rolandstarke\Thumbnail\Facades\Thumbnail;

final class UploadFileThumbnailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private const CONFIG_KEY = 'filesystems.disks.s3-file-uploads';

    private int $fileId;

    public function __construct(int $fileId)
    {
        $this->fileId = $fileId;
    }

    public function handle(
        ErrorLogInterface $errorLog,
        FileRepositoryInterface $fileRepository,
        Repository $configRepository,
        S3ClientFactoryInterface $s3ClientFactory,
    ): void {
        /** @var File $file */
        $file = $fileRepository->find($this->fileId);

        if ($file === null) {
            return;
        }

        $s3Client = $s3ClientFactory->make();

        $s3Config = $configRepository->get(self::CONFIG_KEY, []);

        try {
            $thumbnail = Thumbnail::src($file->getUrl())->crop(80, 80);

            $filepath = null;

            if ($file->getFilePath() !== '' && $file->getFilePath() !== null) {
                $filepath = sprintf('%s/', $file->getFilePath());
            }

            $filepath = sprintf(
                '%s%s',
                $filepath,
                $file->getFileName()
            );

            $thumbnailFilePath = substr($filepath, 0, strpos($filepath, '.'));

            $thumbnailFilePath = sprintf('%s-thumbnail.%s', $thumbnailFilePath, $file->getFileExtension());

            $s3Client->upload(
                Arr::get($s3Config, 'bucket'),
                $thumbnailFilePath,
                $thumbnail->string(),
                'private',
            );

            $cmd = $s3Client->getCommand('GetObject', [
                'Bucket' => Arr::get($s3Config, 'bucket'),
                'Key' => $thumbnailFilePath,
                'ContentType' => $file->getFileType(),
            ]);

            $request = $s3Client->createPresignedRequest($cmd, '+10080 minutes');

            $file->setAttribute('thumbnail_filepath', $thumbnailFilePath);

            $fileRepository->updateThumbnailUrl($file, (string) $request->getUri());
        } catch (\Exception $exception) {
            $errorLog->reportError($exception);
        }
    }
}
