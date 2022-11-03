<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Events;

use App\Http\Resources\API\Departments\DepartmentResource;
use App\Http\Resources\Resource;

final class EventsResource extends Resource
{
    protected function getResponse(): array
    {
        $events = [];


        foreach ($this->resource as $event) {
            $events['data'][] = new EventResource($event);
        }

        $events['page'] = $this->paginationResource($this->resource);

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        return $events;
    }
}
