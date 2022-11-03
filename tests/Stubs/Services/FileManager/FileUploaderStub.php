<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\FileManager;

use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Resources\UploadFileResource;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class FileUploaderStub extends AbstractStub implements FileUploaderInterface
{
    /**
     * @throws \Throwable
     */
    public function upload(UploadFileResource $resource): void
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        $this->fetchResponse(__FUNCTION__);
    }
}
