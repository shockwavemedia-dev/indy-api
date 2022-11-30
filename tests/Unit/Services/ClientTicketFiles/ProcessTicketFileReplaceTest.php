<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ClientTicketFiles;

use App\Models\File;
use App\Models\Tickets\ClientTicketFile;
use App\Models\User;
use App\Services\ClientTicketFiles\Exceptions\ReplaceFileNotAllowedException;
use App\Services\ClientTicketFiles\ProcessTicketFileReplace;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Stubs\Repositories\FileRepositoryStub;
use Tests\Stubs\Services\FileManager\FileRemoverStub;
use Tests\Stubs\Services\FileManager\FileUploaderStub;
use Tests\TestCase;

/**
 * @covers \App\Services\ClientTicketFiles\ProcessTicketFileReplace
 */
final class ProcessTicketFileReplaceTest extends TestCase
{
    /**
     * @throws \App\Services\ClientTicketFiles\Exceptions\FileNotExistException
     * @throws \App\Services\ClientTicketFiles\Exceptions\ReplaceFileNotAllowedException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testReplaceSuccess(): void
    {
        $user = new User();
        $user->setAttribute('id', 1);

        Storage::fake('avatars');
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        $file = new File();
        $file->setAttribute('id', 1);

        $clientTicketFile = new ClientTicketFile();
        $clientTicketFile->setAttribute('id', 1);
        $clientTicketFile->setRelation('file', $file);

        $resource = new CreateFileResource([
            'disk' => 'gcs',
            'uploadedFile' => $uploadedFile,
            'filePath' => '',
            'uploadedBy' => $user,
        ]);

        $fileRepository = new FileRepositoryStub([
            'updateFile' => $file,
        ]);

        $ticketFileReplacer = new ProcessTicketFileReplace(
            $fileRepository,
            new FileRemoverStub(),
            new FileUploaderStub()
        );

        $ticketFileReplacer->replace($user, $clientTicketFile, $uploadedFile, '');

        $actual = $fileRepository->getCalls()[0]['updateFile'];
        $actualResource = $actual[1];

        $actualResource->setFileName(null);

        self::assertEquals($file, $actual[0]);
        self::assertEquals($resource, $actualResource);
    }

    /**
     * @throws \App\Services\ClientTicketFiles\Exceptions\FileNotExistException
     * @throws \App\Services\ClientTicketFiles\Exceptions\ReplaceFileNotAllowedException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testReplaceThrowExceptionAlreadyApproved(): void
    {
        $user = new User();
        $user->setAttribute('id', 1);

        Storage::fake('avatars');
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        $file = new File();
        $file->setAttribute('id', 1);

        $clientTicketFile = new ClientTicketFile();
        $clientTicketFile->setAttribute('id', 1);
        $clientTicketFile->setRelation('file', $file);
        $clientTicketFile->setRelation('approvedBy', $user);

        $ticketFileReplacer = new ProcessTicketFileReplace(
            new FileRepositoryStub(),
            new FileRemoverStub(),
            new FileUploaderStub()
        );

        self::expectException(ReplaceFileNotAllowedException::class);
        $ticketFileReplacer->replace($user, $clientTicketFile, $uploadedFile, '');
    }

    protected function setUp(): void
    {
        $this->markTestIncomplete();
    }
}
