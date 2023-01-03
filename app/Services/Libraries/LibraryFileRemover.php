<?php

declare(strict_types=1);

namespace App\Services\Libraries;

use App\Models\File;
use App\Services\FileManager\AbstractFileManager;
use App\Services\Libraries\Interfaces\LibraryFileRemoverInterface;

final class LibraryFileRemover extends AbstractFileManager implements LibraryFileRemoverInterface
{
    /**
     * @var string
     */
    public const INTERNAL_BUCKET = 'CRM-ADMIN';

    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    public function delete(File $file): void
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
            return;
        }

        $fileCloud->delete();
    }
}
