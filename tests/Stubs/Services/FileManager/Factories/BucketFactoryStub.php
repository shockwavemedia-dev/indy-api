<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\FileManager\Factories;

use App\Services\FileManager\Bucket;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class BucketFactoryStub extends AbstractStub implements BucketFactoryInterface
{
    /**
     * @throws \Throwable
     */
    public function make(string $bucketName): Bucket
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
