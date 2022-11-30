<?php

declare(strict_types=1);

namespace App\Http\Resources\API\MarketingPlanners;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use App\Models\MarketingPlannerTask;

final class MarketingPlannerTaskResource extends Resource
{
    /**
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof MarketingPlannerTask) === false) {
            throw new InvalidResourceTypeException(
                MarketingPlannerTask::class
            );
        }

        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->name,
            'deadline' => $this->resource->deadline,
            'assignees' => $this->resource->getAssignees(),
            'status' => $this->resource->status,
            'notify' => $this->resource->notify,
        ];
    }
}
