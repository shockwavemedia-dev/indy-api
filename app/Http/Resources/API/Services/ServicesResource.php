<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Services;

use App\Http\Resources\Resource;

final class ServicesResource extends Resource
{
    protected function getResponse(): array
    {
        $services = [];

        foreach ($this->resource as $service) {
            $services['data'][] = new ServiceResource($service);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $services['page'] = $this->paginationResource($this->resource);

        return $services;
    }
}
