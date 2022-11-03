<?php

declare(strict_types=1);

namespace Tests\Unit\Services\FileManager;

use App\Models\File;
use App\Services\FileManager\FileRemover;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageObject;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Services\FileManager\Factories\BucketFactoryStub;

/**
 * @covers \App\Services\FileManager\FileRemover
 */
final class FileRemoverTest extends TestCase
{
//    /**
//     * @throws \App\Services\FileManager\Exceptions\GoogleFileNotFoundException
//     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
//     */
//    public function testRemoveSuccess(): void
//    {
//        $file = new File();
//        $file->setFilePath('/');
//        $file->setFileName('test');
//        $file->setBucket('bucket');
//
//        /** @var \Google\Cloud\Storage\StorageObject $storageObject */
//        $storageObject = Mockery::mock(StorageObject::class)
//            ->shouldReceive('exists')
//            ->andReturnTrue()
//            ->shouldReceive('delete')
//            ->getMock();
//
//        /** @var \Google\Cloud\Storage\Bucket $bucket */
//        $bucket = Mockery::mock(Bucket::class)
//            ->shouldReceive('object')
//            ->andReturn($storageObject)
//            ->getMock();
//
//        $bucketFactory = new BucketFactoryStub([
//            'make' => $bucket
//        ]);
//
//        $remover = new FileRemover($bucketFactory);
//
//        $expected = [
//            [
//                'make' => [
//                    'bucket',
//                ]
//            ],
//        ];
//
//        $remover->delete($file);
//
//        self::assertEquals($expected, $bucketFactory->getCalls());
//    }
//
//    /**
//     * @throws \App\Services\FileManager\Exceptions\GoogleFileNotFoundException
//     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
//     */
//    public function testSignedUrlThrowGoogleFileNotFoundException(): void
//    {
//        $file = new File();
//        $file->setFilePath('/');
//        $file->setFileName('test');
//        $file->setBucket('bucket');
//
//        /** @var \Google\Cloud\Storage\StorageObject $storageObject */
//        $storageObject = Mockery::mock(StorageObject::class)
//            ->shouldReceive('exists')
//            ->andReturnFalse()
//            ->getMock();
//
//        /** @var \Google\Cloud\Storage\Bucket $bucket */
//        $bucket = Mockery::mock(Bucket::class)
//            ->shouldReceive('object')
//            ->andReturn($storageObject)
//            ->getMock();
//
//        $bucketFactory = new BucketFactoryStub([
//            'make' => $bucket
//        ]);
//
//        $remover = new FileRemover($bucketFactory);
//
//        $expected = [
//            [
//                'make' => [
//                    'bucket',
//                ]
//            ],
//        ];
//
//        $remover->delete($file);
//
//        self::assertEquals($expected, $bucketFactory->getCalls());
//    }
//
    protected function setUp(): void
    {
        $this->markTestSkipped();
    }
}
