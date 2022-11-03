<?php

declare(strict_types=1);

namespace Tests\Unit\Services\FileManager\Resolvers;

use App\Services\FileManager\Resolvers\GoogleCloudConfigResolver;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\ThirdParty\Illuminate\Config\Repository\ConfigStub;

/**
 * @covers \App\Services\FileManager\Resolvers\GoogleCloudConfigResolver
 */
final class FileManagerConfigResolverTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testResolveSuccess(): void
    {
        $repository = new ConfigStub([
            'get' => [
                'project_id' => 'test',
                'key_file_path' => 'test'
            ],
        ]);

        $resolver = new GoogleCloudConfigResolver($repository);

        $expectedCall = [
            [
                'get' => [
                    'filesystems.disks.gcs',
                    [],
                ],
            ],
        ];

        $expected = [
            'project_id' => 'test',
            'key_file_path' => 'test',
        ];

        $resource = $resolver->resolve();

        $actual = [
            'project_id' => $resource->getProjectId(),
            'key_file_path' => $resource->getKeyFilePath(),
        ];

        self::assertEquals($expected, $actual);
        self::assertEquals($expectedCall, $repository->getCalls());
    }
}
