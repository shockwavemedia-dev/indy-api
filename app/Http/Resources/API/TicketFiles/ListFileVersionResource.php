<?php

declare(strict_types=1);

namespace App\Http\Resources\API\TicketFiles;

use App\Http\Resources\Resource;

final class ListFileVersionResource extends Resource
{
    protected function getResponse(): array
    {
        $files = [];

        foreach ($this->resource as $file) {
            $files['data'][] = new FileVersionResource($file);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        return $files;
    }
}
