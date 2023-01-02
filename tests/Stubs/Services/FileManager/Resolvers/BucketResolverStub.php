<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\FileManager\Resolvers;

use App\Services\FileManager\Interfaces\BucketResolverInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class BucketResolverStub extends AbstractStub implements BucketResolverInterface
{
    /**
     * @throws \Throwable
     */
    public function resolve(string $bucketName): mixed
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
