<?php

declare(strict_types=1);

namespace App\Http\Resources\API\PrinterJobs;

use App\Http\Resources\Resource;

final class PrinterJobsResource extends Resource
{

    protected function getResponse(): array
    {
        $printerJobs = $this->resource;

        $results = [];

        foreach ($printerJobs as $printerJob) {
            $results['data'][] = new PrinterJobResource($printerJob);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $results['page'] = $this->paginationResource($this->resource);

        return $results;
    }
}
