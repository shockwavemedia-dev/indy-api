<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Screens;

use App\Http\Resources\Resource;

final class ScreensResource extends Resource
{
    protected function getResponse(): array
    {
        $screens = $this->resource;

        $results = [];

        foreach ($screens as $screen) {
            $results['data'][] = new ScreenResource($screen);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $results['page'] = $this->paginationResource($this->resource);

        return $results;
    }
}
