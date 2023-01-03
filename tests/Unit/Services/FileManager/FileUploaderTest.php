<?php

declare(strict_types=1);

namespace Tests\Unit\Services\FileManager;

use App\Jobs\File\UploadFileJob;
use App\Models\Client;
use App\Models\File;
use App\Models\User;
use App\Services\FileManager\FileUploader;
use App\Services\FileManager\Resources\UploadFileResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * @covers \App\Services\FileManager\FileUploader
 */
final class FileUploaderTest extends TestCase
{
    /**
     * @throws \App\Services\FileManager\Exceptions\GoogleFileNotFoundException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function testUploadSuccess(): void
    {
        $client = new Client();
        $client->setAttribute('id', 1);
        $client->setClientCode('client-code');

        Storage::fake('avatars');
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        $file = new File();
        $file->setAttribute('id', 1);
        $file->setFileName('avatar.jpg');
        $file->setFilePath('/');
        $file->setBucket('bucket');

        $user = new User();
        $user->setAttribute('id', 1);

        $resource = new UploadFileResource([
            'fileObject' => $uploadedFile,
            'fileModel' => $file,
        ]);

        $uploader = new FileUploader();

        self::expectsJobs([
            UploadFileJob::class,
        ]);

        $uploader->upload($resource);
    }
}
