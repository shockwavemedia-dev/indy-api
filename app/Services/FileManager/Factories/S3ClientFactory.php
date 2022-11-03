<?php

declare(strict_types=1);

namespace App\Services\FileManager\Factories;

use App\Services\FileManager\Interfaces\S3ClientFactoryInterface;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use Aws\S3\S3ClientInterface;
use Aws\Sdk;
use Illuminate\Contracts\Config\Repository;

final class S3ClientFactory implements S3ClientFactoryInterface
{
    /**
     * @var string
     */
    private const CONFIG_KEY = 'filesystems.disks.s3-file-uploads';

    private Repository $configRepository;

    public function __construct(Repository $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function make(): S3Client
    {
        $s3Config = $this->configRepository->get(self::CONFIG_KEY, []);

        $credentials = new Credentials($s3Config['key'], $s3Config['secret']);

        return new S3Client([
            'region' => 'us-west-2',
            'version' => 'latest',
            'credentials' => $credentials,
        ]);
    }
}
