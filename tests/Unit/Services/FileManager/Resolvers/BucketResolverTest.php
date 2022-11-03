<?php

declare(strict_types=1);

namespace Tests\Unit\Services\FileManager\Resolvers;

use App\Services\FileManager\Exceptions\BucketNotFoundException;
use App\Services\FileManager\Resolvers\BucketResolver;
use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Services\FileManager\Factories\BucketFactoryStub;
use Tests\Stubs\Services\FileManager\Factories\StorageClientFactoryStub;

/**
 * @covers \App\Services\FileManager\Resolvers\BucketResolver
 */
final class BucketResolverTest extends TestCase
{
    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \App\Services\FileManager\Exceptions\BucketNotFoundException
     */
    public function testResolveSuccess(): void
    {
        $this->markTestSkipped('must be revisited.');

        $bucket = Mockery::mock(Bucket::class)
            ->shouldReceive('exists')
            ->andReturnTrue()
            ->getMock();

        $storageClient = Mockery::mock(StorageClient::class)
            ->shouldReceive('bucket')
            ->with('test')
            ->andReturn($bucket)
            ->getMock();

        $storageClientFactory = new StorageClientFactoryStub([
            'make' => $storageClient
        ]);

        $bucketFactory = new BucketFactoryStub();

        $expectedCall = [
            [
                'make' => [],
            ]
        ];

        $resolver = new BucketResolver($storageClientFactory);

        $result = $resolver->resolve('test');

        self::assertInstanceOf(Bucket::class, $result);
        self::assertEquals($expectedCall, $storageClientFactory->getCalls());
    }

    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \App\Services\FileManager\Exceptions\BucketNotFoundException
     */
    public function testResolveThrowBucketNotFoundException(): void
    {
        $this->markTestSkipped('must be revisited.');

        $bucket = Mockery::mock(Bucket::class)
            ->shouldReceive('exists')
            ->andReturnFalse()
            ->getMock();

        $storageClient = Mockery::mock(StorageClient::class)
            ->shouldReceive('bucket')
            ->with('test')
            ->andReturn($bucket)
            ->getMock();

        $storageClientFactory = new StorageClientFactoryStub([
            'make' => $storageClient
        ]);

        $expectedCalls = [
            'storageClientFactory' => [
                [
                    'make' => [],
                ]
            ]
        ];

        self::expectException(BucketNotFoundException::class);

        $resolver = new BucketResolver($storageClientFactory);

        $result = $resolver->resolve('test');

        $actualCalls = [
            'storageClientFactory' => $storageClientFactory->getCalls()
        ];

        self::assertInstanceOf(Bucket::class, $result);
        self::assertEquals($expectedCalls, $actualCalls);
    }
}
