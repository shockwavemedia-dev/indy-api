<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Libraries;

use App\Models\File;
use App\Services\FileManager\Exceptions\GoogleFileNotFoundException;
use App\Services\Libraries\LibraryFileFetcher;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageObject;
use Mockery;
use Tests\Stubs\Services\FileManager\Factories\BucketFactoryStub;
use Tests\TestCase;

/**
 * @covers \App\Services\Libraries\LibraryFileFetcher
 */
final class LibraryFileFetcherTest extends TestCase
{
    /**
     * @throws \App\Services\FileManager\Exceptions\GoogleFileNotFoundException
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     */
    public function testFetchSuccess(): void
    {
        $file = new File();
        $file->setFilePath('/');
        $file->setFileName('test');
        $file->setBucket('test');

        /** @var \Google\Cloud\Storage\StorageObject $storageObject */
        $storageObject = Mockery::mock(StorageObject::class)
            ->shouldReceive('exists')
            ->andReturnTrue()
            ->shouldReceive('signedUrl')
            ->andReturn('test')
            ->getMock();

        /** @var \Google\Cloud\Storage\Bucket $bucket */
        $bucket = Mockery::mock(Bucket::class)
        ->shouldReceive('object')
        ->andReturn($storageObject)
        ->getMock();

        $bucketFactory = new BucketFactoryStub([
            'make' => $bucket,
        ]);

        $fileFetcher = new LibraryFileFetcher($bucketFactory);
        $expected = [
            [
                'make' => [
                    'CRM-ADMIN',
                ],
            ],
        ];

        $result = $fileFetcher->signedUrl($file);

        self::assertEquals('test', $result);

        self::assertEquals($expected, $bucketFactory->getCalls());
    }

    /**
     * @throws \App\Services\FileManager\Exceptions\GoogleFileNotFoundException
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
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

        $fileFetcher = new LibraryFileFetcher($bucketFactory);
        $expected = [
            [
                'make' => [
                    'CRM-ADMIN',
                ],
            ],
        ];

        self::expectException(GoogleFileNotFoundException::class);

        $fileFetcher->signedUrl($file);

        self::assertEquals($expected, $bucketFactory->getCalls());
    }

    protected function setUp(): void
    {
        $this->markTestIncomplete();
    }
}
