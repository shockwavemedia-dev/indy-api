<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\Files;

use App\Models\File;
use App\Services\Files\Interfaces\FileFactoryInterface;
use App\Services\Files\Resources\CreateFileResource;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class FileFactoryStub extends AbstractStub implements FileFactoryInterface
{
    /**
     * @throws \Throwable
     */
    public function make(CreateFileResource $resource): File
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
