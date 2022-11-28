<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Libraries;

use App\Jobs\File\UploadFileJob;
use App\Models\File;
use App\Models\Library;
use App\Models\User;
use App\Services\Libraries\LibraryFileUploader;
use App\Services\Libraries\Resources\LibraryProcessResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * @covers \App\Services\Libraries\LibraryFileUploader
 */
final class LibraryFileUploaderTest extends TestCase
{
    /**
     * @throws \App\Services\FileManager\Exceptions\GoogleFileNotFoundException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function testUploadSuccess(): void
    {
        Storage::fake('avatars');
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        $file = new File();
        $file->setAttribute('id', 1);
        $file->setFileName('avatar.jpg');
        $file->setFilePath('/');

        $library = new Library();
        $library->setAttribute('id', 1);

        $user = new User();
        $user->setAttribute('id', 1);

        $resource = new LibraryProcessResource([
            'uploadedFile' => $uploadedFile,
            'file' => $file,
            'user' => $user,
            'library' => $library,
        ]);

        $uploader = new LibraryFileUploader();

        self::expectsJobs([
            UploadFileJob::class,
        ]);

        $uploader->upload($resource);
    }
}
