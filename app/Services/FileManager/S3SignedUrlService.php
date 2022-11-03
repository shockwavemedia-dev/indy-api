<?php

declare(strict_types=1);

namespace App\Services\FileManager;

use App\Jobs\File\UploadFileThumbnailJob;
use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileManager\Interfaces\S3ClientFactoryInterface;
use App\Services\FileManager\Interfaces\S3SignedUrlServiceInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Arr;

final class S3SignedUrlService implements S3SignedUrlServiceInterface
{
    /**
     * @var string
     */
    private const CONFIG_KEY = 'filesystems.disks.s3-file-uploads';

    private FileRepositoryInterface $fileRepository;

    private Repository $configRepository;

    private S3ClientFactoryInterface $s3ClientFactory;

    public function __construct(
        Repository $configRepository,
        S3ClientFactoryInterface $s3ClientFactory,
        FileRepositoryInterface $fileRepository,
    ) {
        $this->configRepository = $configRepository;
        $this->s3ClientFactory = $s3ClientFactory;
        $this->fileRepository = $fileRepository;
    }

    public function upload(File $file): void
    {
        $s3Client = $this->s3ClientFactory->make();

        $s3Config = $this->configRepository->get(self::CONFIG_KEY, []);

        $filepath = null;

        if ($file->getFilePath() !== '' && $file->getFilePath() !== null) {
            $filepath =  sprintf('%s/', $file->getFilePath());
        }

        $filepath = sprintf(
            '%s%s',
            $filepath,
            $file->getFileName()
        );

        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => Arr::get($s3Config, 'bucket'),
            'Key' => $filepath,
            'ContentType' => $file->getFileType(),
        ]);

        $expiryDate = (new Carbon())->addMinutes(10080);

        $request = $s3Client->createPresignedRequest($cmd, '+10080 minutes');

        $this->fileRepository->updateSignedUrl(
            $file,
            (string)$request->getUri(),
            $expiryDate
        );

        UploadFileThumbnailJob::dispatch($file->getId());
    }
}
