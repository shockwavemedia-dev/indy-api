<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Repositories\FileRepository;
use App\Services\Files\Resources\CreateFileResource;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * @covers \App\Repositories\FileRepository
 */
final class FileRepositoryTest extends TestCase
{
    public function testDeleteFile(): void
    {
        $user = $this->env->user()->user;

        $file = $this->env->file(['uploaded_by' => $user->getId()])->file;

        $repository = new FileRepository();

        $repository->deleteFile($file, $user);

        $file->refresh();

        $this->assertEquals($file->getDeletedById(), $user->getId());
    }

    public function testFindAllByTicket(): void
    {
        $ticket = $this->env->ticket;

        $file1 = $this->env->file;
        $file2 = $this->env->file;

        $clientFile1 = $this->env->clientTicketFile([
            'ticket_id' => $ticket->getId(),
            'file_id' => $file1->getId(),
        ])->clientTicketFile;

        $clientFile2 = $this->env->clientTicketFile([
            'ticket_id' => $ticket->getId(),
            'file_id' => $file2->getId(),
        ])->clientTicketFile;

        $expected = [
            $clientFile1->getId(),
            $clientFile2->getId(),
        ];

        $repository = new FileRepository();

        $files = $repository->findAllByTicket($ticket);

        self::assertEquals($expected, array_column($files->toArray()['data'], 'id'));
    }

    public function testFindByNameAndPath(): void
    {
        $user = $this->env->user()->user;

        $file = $this->env->file(['uploaded_by' => $user->getId()])->file;

        $repository = new FileRepository();

        $findByNameAndPath = $repository->findByNameAndPath($file->getFileName(), $file->getFilePath());

        $file->refresh();

        $this->assertEquals($file->getFileName(), $findByNameAndPath->getFileName());
        $this->assertEquals($file->getFilePath(), $findByNameAndPath->getFilePath());
    }

    public function testIncrementVersion(): void
    {
        $user = $this->env->user()->user;

        $file = $this->env->file(['uploaded_by' => $user->getId()])->file;

        $repository = new FileRepository();

        $repository->incrementVersion($file);

        $file->refresh();

        $this->assertEquals(2, $file->getVersion());
    }

    public function testUpdateBucket(): void
    {
        $file = $this->env->file;

        $repository = new FileRepository();

        $repository->updateBucket($file, 'test');

        $file->refresh();

        self::assertEquals('test', $file->getBucket());
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     * @throws \App\Services\Users\Exceptions\InvalidDepartmentsException
     */
    public function testUpdateFileSuccess(): void
    {
        $user = $this->env->user()->user;

        $file = $this->env->file(['uploaded_by' => $user->getId()])->file;

        Storage::fake('avatars');
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        $updateResource = new CreateFileResource([
            'fileName' => '96365efc65a27cac2e477c809f19f2def6bc298f-avatar.jpg',
            'uploadedFile' => $uploadedFile,
            'uploadedBy' => $user,
            'filePath' => 'december/poster',
            'disk' => 'gcs',
            'version' => 2,
            'url' => 'https://storage.googleapis.com/aap1-client/december/poster/96365efc65a27cac2e477c809f19f2def6bc298f-feedback.PNG?GoogleAccessId=test2-707%40loyal-burner-340623.iam.gserviceaccount.com&Expires=1676699829&Signature=BM%2ByV1RKjI8HWkJdcvRmyPVcHwNIFx6TWHiEwhf00v35gzBuVbq5TpPq62xC%2BCPDNsVPjh8ez75n%2F1c9ts0ZGwPawV29oIkhBAnXdNSihvpQ2EqsUPCEEzyEKDhHgaLg4BKNNi6dmehcvybN%2BV2hKJceDTkcetWiRj48iF2wBFh%2B7%2BdExMJ%2B2mlc8FJ9pHnEfF9GQGzQEA3h%2BuPzpxGnYKXj1GGzn%2Bsljk43AgAB9cOUw8ku4nNkeACOzR5UybY8UB2UVTRuu40O8JZG48oGx9o3nKN8ZWQilvoTzqhXdg4gqFevtd0iAUBH80yl48%2B%2BnRzbnSTDLyE7cwbuGXzyTA%3D%3D',
        ]);

        $repository = new FileRepository();

        $expected = [
            'originalName' => 'avatar.jpg',
            'fileName' => '96365efc65a27cac2e477c809f19f2def6bc298f-avatar.jpg',
            'uploadedBy' => $user->getId(),
            'fileSize' => 695,
            'filePath' => 'december/poster',
            'fileType' => 'image/jpeg',
            'disk' => 'gcs',
            'version' => 2,
            'url' => 'https://storage.googleapis.com/aap1-client/december/poster/96365efc65a27cac2e477c809f19f2def6bc298f-feedback.PNG?GoogleAccessId=test2-707%40loyal-burner-340623.iam.gserviceaccount.com&Expires=1676699829&Signature=BM%2ByV1RKjI8HWkJdcvRmyPVcHwNIFx6TWHiEwhf00v35gzBuVbq5TpPq62xC%2BCPDNsVPjh8ez75n%2F1c9ts0ZGwPawV29oIkhBAnXdNSihvpQ2EqsUPCEEzyEKDhHgaLg4BKNNi6dmehcvybN%2BV2hKJceDTkcetWiRj48iF2wBFh%2B7%2BdExMJ%2B2mlc8FJ9pHnEfF9GQGzQEA3h%2BuPzpxGnYKXj1GGzn%2Bsljk43AgAB9cOUw8ku4nNkeACOzR5UybY8UB2UVTRuu40O8JZG48oGx9o3nKN8ZWQilvoTzqhXdg4gqFevtd0iAUBH80yl48%2B%2BnRzbnSTDLyE7cwbuGXzyTA%3D%3D',
        ];

        $file = $repository->updateFile($file, $updateResource);

        $actual = [
            'originalName' => $file->getOriginalFileName(),
            'fileName' => $file->getFileName(),
            'fileSize' => $file->getFileSize(),
            'filePath' => $file->getFilePath(),
            'fileType' => $file->getFileType(),
            'uploadedBy' => $file->getUploadedById(),
            'disk' => $file->getFileDisk(),
            'version' => $file->getVersion(),
            'url' => $file->getUrl(),
        ];

        self::assertEquals($expected, $actual);
    }

    public function testUpdateSignedUrl(): void
    {
        $user = $this->env->user()->user;

        $file = $this->env->file(['uploaded_by' => $user->getId()])->file;

        $repository = new FileRepository();

        $dateToday = new Carbon();

        $newUrl = 'https://storage.googleapis.com/aap1-client/december/poster/96365efc65a27cac2e477c809f19f2def6bc298f-feedback.PNG';

        $repository->updateSignedUrl($file, $newUrl, $dateToday);

        $file->refresh();

        $this->assertEquals($newUrl, $file->getUrl());
    }
}
