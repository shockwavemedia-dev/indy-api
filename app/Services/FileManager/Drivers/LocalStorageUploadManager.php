<?php

declare(strict_types=1);

namespace App\Services\FileManager\Drivers;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\FileManager\Interfaces\FileUploadManagerResolverInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Http\File as HttpFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

final class LocalStorageUploadManager extends AbstractFileManager implements FileUploadManagerResolverInterface
{
    public function __construct(
        FileRepositoryInterface $fileRepository,
        ErrorLogInterface $sentryHandler
    ) {
        parent::__construct($fileRepository, $sentryHandler);
    }

    public function upload(File $file, ?string $rawFile = null): void
    {
        $uploadedFile = $this->convertFromBase64ToUploadedFile($rawFile);

        $uploadedFile->storeAs($file->getBucket(), $file->getFileName(), 'public');

        $signedUrl = \sprintf(
            '%s/storage/%s/%s',
            URL::current(),
            $file->getBucket(),
            $file->getFileName()
        );

        $file->setFilePath($file->getBucket());

        $this->fileRepository->updateSignedUrl($file, $signedUrl);
    }

    public function supports(string $driver): bool
    {
        return $driver === 'local';
    }

    private function convertFromBase64ToUploadedFile(string $base64File): UploadedFile
    {
        // Get file data base64 string
        $fileData = base64_decode(Arr::last(explode(',', $base64File)));

        // Create temp file and get its absolute path
        $tempFile = tmpfile();
        $tempFilePath = stream_get_meta_data($tempFile)['uri'];

        // Save file data in file
        file_put_contents($tempFilePath, $fileData);

        $tempFileObject = new HttpFile($tempFilePath);
        $file = new UploadedFile(
            $tempFileObject->getPathname(),
            $tempFileObject->getFilename(),
            $tempFileObject->getMimeType(),
            0,
            true // Mark it as test, since the file isn't from real HTTP POST.
        );

        // Close this file after response is sent.
        // Closing the file will cause to remove it from temp director!
        app()->terminating(function () use ($tempFile) {
            fclose($tempFile);
        });

        // return UploadedFile object
        return $file;
    }
}
