<?php

namespace Tests\Stubs\Services\FileManager;

use App\Models\File;
use App\Services\FileManager\Interfaces\FileRemoverInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class FileRemoverStub extends AbstractStub implements FileRemoverInterface
{
    /**
     * @throws \Throwable
     */
    public function delete(File $file): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }
}
