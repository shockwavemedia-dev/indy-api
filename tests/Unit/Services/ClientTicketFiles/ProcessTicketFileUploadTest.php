<?php

declare(strict_types=1);

namespace Tests\Unit\Services\ClientTicketFiles;

use App\Models\File;
use App\Models\Tickets\ClientTicketFile;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Models\Users\AdminUser;
use App\Services\ClientTicketFiles\ProcessTicketFileUpload;
use App\Services\FileManager\Resources\UploadFileResource;
use App\Services\Files\Resources\CreateFileResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Stubs\Services\ClientTicketFiles\TicketFileFactoryStub;
use Tests\Stubs\Services\FileManager\FileUploaderStub;
use Tests\TestCase;

/**
 * @covers \App\Services\ClientTicketFiles\ProcessTicketFileUpload
 */
final class ProcessTicketFileUploadTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testProcessSuccess(): void
    {
        $adminUser = new AdminUser();
        $adminUser->setAttribute('id', 1);

        $user = new User();
        $user->setAttribute('id', 1);
        $user->setRelation('userType', $adminUser);

        Storage::fake('avatars');
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        $file = new File();
        $file->setAttribute('id', 1);

        $ticket = new Ticket();
        $ticket->setAttribute('id', 1);

        $clientTicketFile = new ClientTicketFile();
        $clientTicketFile->setAttribute('id', 1);
        $clientTicketFile->setRelation('file', $file);
        $clientTicketFile->setRelation('ticket', $ticket);

        $resource = new CreateFileResource([
            'disk' => 'gcs',
            'uploadedFile' => $uploadedFile,
            'filePath' => '',
            'uploadedBy' => $user
        ]);

        $fileUploader = new FileUploaderStub();

        $factory = new TicketFileFactoryStub([
            'make' => $clientTicketFile,
        ]);

        $fileUploaderProcessor = new ProcessTicketFileUpload($fileUploader, $factory);

        $expectedCalls = [
            'fileUploader' => [
                [
                    'upload' => [
                        new UploadFileResource([
                            'fileObject' => $uploadedFile,
                            'fileModel' => $file,
                        ])
                    ],
                ],
            ],
        ];

        $fileUploaderProcessor->process($file, $user, $ticket, $uploadedFile);

        $actualCalls = [
            'fileUploader' => $fileUploader->getCalls()
        ];

        self::assertEquals($expectedCalls, $actualCalls);
    }

    protected function setUp(): void
    {
        $this->markTestIncomplete();
    }
}
