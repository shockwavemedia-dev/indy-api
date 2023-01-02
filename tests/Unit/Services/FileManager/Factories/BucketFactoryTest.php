<?php

declare(strict_types=1);

namespace Tests\Unit\Services\FileManager\Factories;

use App\Services\FileManager\Factories\BucketFactory;
use Google\Cloud\Core\Exception\ConflictException;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Exceptions\ErrorLogStub;
use Tests\Stubs\Services\FileManager\Factories\StorageClientFactoryStub;
use Tests\Stubs\Services\FileManager\Resolvers\BucketResolverStub;
use Tests\Stubs\Services\FileManager\Resolvers\FileManagerConfigResolverStub;

/**
 * @covers \App\Services\FileManager\Factories\BucketFactory
 * @
 */
final class BucketFactoryTest extends TestCase
{
    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Google\Cloud\Core\Exception\ConflictException
     * @throws \Google\Cloud\Core\Exception\GoogleException
     */
    public function testMakeSuccess(): void
    {
        $bucket = Mockery::mock(Bucket::class)
        ->shouldReceive('exists')
        ->andReturnFalse()
        ->getMock();

        $storageClient = Mockery::mock(StorageClient::class)
            ->shouldReceive('createBucket')
            ->andReturn($bucket)
            ->getMock();

        $sentryHandler = new ErrorLogStub();
        $storageClientFactory = new StorageClientFactoryStub([
            'make' => $storageClient,
        ]);

        $bucketResolver = new BucketResolverStub([
            'resolve' => $bucket,
        ]);

        $fileConfigResolver = new FileManagerConfigResolverStub([
            'resolve' => 'gcs',
        ]);

        $factory = new BucketFactory($bucketResolver, $fileConfigResolver, $sentryHandler, $storageClientFactory);

        $bucket = $factory->make('test');

        self::assertInstanceOf(Bucket::class, $bucket);
    }

    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Google\Cloud\Core\Exception\ConflictException
     * @throws \Google\Cloud\Core\Exception\GoogleException
     */
    public function testMakeThrowBucketNameExistsException(): void
    {
        $storageClient = Mockery::mock(StorageClient::class)
            ->shouldReceive('createBucket')
            ->with('test-client')
            ->andThrow(ConflictException::class)
            ->getMock();

        $sentryHandler = new ErrorLogStub();
        $storageClientFactory = new StorageClientFactoryStub([
            'make' => $storageClient,
        ]);

        $bucket = Mockery::mock(Bucket::class)
            ->shouldReceive('exists')
            ->andReturnFalse()
            ->getMock();

        $bucketResolver = new BucketResolverStub([
            'resolve' => $bucket,
        ]);

        $fileConfigResolver = new FileManagerConfigResolverStub([
            'resolve' => 'gcs',
        ]);

        $factory = new BucketFactory($bucketResolver, $fileConfigResolver, $sentryHandler, $storageClientFactory);

        $factory->make('test');

        self::assertEquals([
            [
                'resolve' => [
                    'test-client',
                ],
            ],
        ], $bucketResolver->getCalls());
    }

    protected function setUp(): void
    {
        $this->markTestIncomplete();
    }
}
