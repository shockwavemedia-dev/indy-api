<?php

declare(strict_types=1);

namespace App\Services\Libraries;

use App\Models\File;
use App\Services\FileManager\AbstractFileManager;
use App\Services\FileManager\Exceptions\GoogleFileNotFoundException;
use App\Services\Libraries\Interfaces\LibraryFileFetcherInterface;
use Carbon\Carbon;

final class LibraryFileFetcher extends AbstractFileManager implements LibraryFileFetcherInterface
{
    /**
     * @var string
     */
    public const INTERNAL_BUCKET = 'CRM-ADMIN';

    /**
     * @throws \App\Services\FileManager\Exceptions\GoogleFileNotFoundException
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    public function signedUrl(File $file, ?int $expireInMinutes = 1051920): string
    {
        $this->resolveBucket(self::INTERNAL_BUCKET);

        $filePath = $file->getFileName();

        if ($file->getFilePath() !== '') {
            $filePath = \sprintf(
                '%s/%s',
                $file->getFilePath(),
                $file->getFileName()
            );
        }

        $fileCloud = $this->bucket->object($filePath);

        if ($fileCloud->exists() === false) {
            throw new GoogleFileNotFoundException(
                \sprintf('File %s not found in google cloud storage.', $filePath)
            );
        }

        return $fileCloud->signedUrl((new Carbon())->addMinutes($expireInMinutes));
    }
}
