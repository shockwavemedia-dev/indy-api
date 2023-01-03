<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\FileManager\Resolvers;

use App\Services\FileManager\Interfaces\GoogleCloudConfigResolverInterface;
use App\Services\FileManager\Resources\GoogleCloudConfigResource;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class GoogleCloudConfigResolverStub extends AbstractStub implements GoogleCloudConfigResolverInterface
{
    /**
     * @throws \Throwable
     */
    public function resolve(): GoogleCloudConfigResource
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
