<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Libraries;

use App\Models\File;
use App\Services\Libraries\LibraryFileRemover;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageObject;
use Mockery;
use Tests\Stubs\Services\FileManager\Factories\BucketFactoryStub;
use Tests\TestCase;

/**
 * @covers \App\Services\Libraries\LibraryFileRemover
 * @covers \App\Services\FileManager\AbstractFileManager
 */
final class LibraryFileRemoverTest extends TestCase
{
    /**
     * @throws \App\Services\FileManager\Exceptions\GoogleFileNotFoundException
     */
    public function testDeleteSuccess(): void
    {
        $file = new File();
        $file->setFilePath('/');
        $file->setFileName('test');

        /** @var \Google\Cloud\Storage\StorageObject $storageObject */
        $storageObject = Mockery::mock(StorageObject::class)
            ->shouldReceive('exists')
            ->andReturnTrue()
            ->shouldReceive('delete')
            ->getMock();

        /** @var \Google\Cloud\Storage\Bucket $bucket */
        $bucket = Mockery::mock(Bucket::class)
            ->shouldReceive('object')
            ->andReturn($storageObject)
            ->getMock();

        $bucketFactory = new BucketFactoryStub([
            'make' => $bucket,
        ]);

        $fileFetcher = new LibraryFileRemover($bucketFactory);

        $expected = [
            [
                'make' => [
                    'CRM-ADMIN',
                ],
            ],
        ];

        $fileFetcher->delete($file);

        self::assertEquals($expected, $bucketFactory->getCalls());
    }

    /**
     * @throws \App\Services\FileManager\Exceptions\GoogleFileNotFoundException
     */
    public function testFetchThrowGoogleFileNotFoundException(): void
    {
        $file = new File();
        $file->setFilePath('/');
        $file->setFileName('test');

        /** @var \Google\Cloud\Storage\StorageObject $storageObject */
        $storageObject = Mockery::mock(StorageObject::class)
            ->shouldReceive('exists')
            ->andReturnFalse()
            ->getMock();

        /** @var \Google\Cloud\Storage\Bucket $bucket */
        $bucket = Mockery::mock(Bucket::class)
            ->shouldReceive('object')
            ->andReturn($storageObject)
            ->getMock();

        $bucketFactory = new BucketFactoryStub([
            'make' => $bucket,
        ]);

        $fileFetcher = new LibraryFileRemover($bucketFactory);
        $expected = [
            [
                'make' => [
                    'CRM-ADMIN',
                ],
            ],
        ];

        $fileFetcher->delete($file);

        self::assertEquals($expected, $bucketFactory->getCalls());
    }

    protected function setUp(): void
    {
        $this->markTestIncomplete();
    }
}
