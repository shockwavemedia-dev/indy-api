<?php

declare(strict_types=1);

namespace Tests\Unit\Services\FileManager\Factories;

use App\Services\FileManager\Factories\StorageClientFactory;
use App\Services\FileManager\Resources\GoogleCloudConfigResource;
use Google\Cloud\Storage\StorageClient;
use Tests\Stubs\Services\FileManager\Resolvers\GoogleCloudConfigResolverStub;
use Tests\TestCase;

/**
 * @covers \App\Services\FileManager\Factories\StorageClientFactory
 */
final class StorageClientFactoryTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testMakeSuccess(): void
    {
        // Actual Config
        $resource = new GoogleCloudConfigResource([
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID', 'loyal-burner-340623'),
            'keyFilePath' => env('GOOGLE_CLOUD_KEY_FILE', base_path().'/loyal-burner-340623-bff15907a50b.json'),
        ]);

        $configResolver = new GoogleCloudConfigResolverStub([
            'resolve' => $resource,
        ]);

        $factory = new StorageClientFactory($configResolver);

        $storageClient = $factory->make();

        self::assertInstanceOf(StorageClient::class, $storageClient);
    }
}
