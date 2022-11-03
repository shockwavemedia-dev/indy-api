<?php

namespace Tests\Stubs\Services\FileManager\Resolvers;

use App\Services\FileManager\Interfaces\FileManagerConfigResolverInterface;
use Tests\Stubs\AbstractStub;

final class FileManagerConfigResolverStub extends AbstractStub implements FileManagerConfigResolverInterface
{
    /**
     * @throws \Throwable
     */
    public function resolve(): array
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
