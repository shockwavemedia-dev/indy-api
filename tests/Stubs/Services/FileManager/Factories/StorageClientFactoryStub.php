<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\FileManager\Factories;

use App\Services\FileManager\Interfaces\StorageClientFactoryInterface;
use Google\Cloud\Storage\StorageClient;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class StorageClientFactoryStub extends AbstractStub implements StorageClientFactoryInterface
{
    /**
     * @throws \Throwable
     */
    public function make(): StorageClient
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
