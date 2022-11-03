<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Printers;

use App\Http\Resources\Resource;

final class PrintersResource extends Resource
{
    protected function getResponse(): array
    {
        $printers = $this->resource;

        $results = [];

        foreach ($printers as $printer) {
            $results['data'][] = new PrinterResource($printer);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $results['page'] = $this->paginationResource($this->resource);

        return $results;
    }
}
