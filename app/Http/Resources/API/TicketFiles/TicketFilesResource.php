<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketFiles;

use App\Http\Resources\Resource;

final class TicketFilesResource extends Resource
{
    protected function getResponse(): array
    {
        $files = [];

        foreach ($this->resource as $file) {
            $files['data'][] = new TicketFileResource($file);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $files['page'] = $this->paginationResource($this->resource);

        return $files;
    }
}
