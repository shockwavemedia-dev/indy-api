<?php

declare(strict_types=1);

namespace App\Services\FileManager\Drivers;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\File;
use App\Models\User;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileManager\Interfaces\FileRemoverManagerResolverInterface;
use App\Services\FileManager\Interfaces\S3ClientFactoryInterface;
use League\Flysystem\UnableToDeleteFile;
use Throwable;

final class S3FileRemoverManager extends AbstractFileManager implements FileRemoverManagerResolverInterface
{
    /**
     * @var string
     */
    private const CONFIG_KEY = 'filesystems.disks.s3-file-uploads';

    private S3ClientFactoryInterface $s3ClientFactory;

    public function __construct(
        ErrorLogInterface $sentryHandler,
        FileRepositoryInterface $fileRepository,
        S3ClientFactoryInterface $s3ClientFactory,
    ) {
        $this->s3ClientFactory = $s3ClientFactory;

        parent::__construct($fileRepository, $sentryHandler);
    }

    public function remove(File $file, User $user): void
    {
        try {
            $s3Client = $this->s3ClientFactory->make();

            $path = null;

            if ($file->getFilePath() !== '' && $file->getFilePath() !== null) {
                $path = sprintf('%s/', $file->getFilePath());
            }

            $filepath = sprintf(
                '%s%s',
                $path,
                $file->getFileName()
            );

            $arguments = [
                'Bucket' => $file->getBucket(),
                'Key' => $filepath,
            ];

            $command = $s3Client->getCommand('DeleteObject', $arguments);

            try {
                $s3Client->execute($command);
            } catch (Throwable $exception) {
                throw UnableToDeleteFile::atLocation($path, '', $exception);
            }

            $this->fileRepository->deleteFile($file, $user);
        } catch (\Exception $exception) {
            $this->sentryHandler->reportError($exception);
        }
    }

    public function supports(string $driver): bool
    {
        return $driver === 's3';
    }
}
