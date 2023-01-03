<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Libraries;

use App\Http\Resources\Resource;

final class LibrariesResource extends Resource
{
    protected function getResponse(): array
    {
        $libraries = [];

        foreach ($this->resource as $library) {
            $libraries['data'][] = new LibraryResource($library, true);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $libraries['page'] = $this->paginationResource($this->resource);

        return $libraries;
    }
}
