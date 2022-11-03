<?php

declare(strict_types=1);

namespace App\Http\Resources\API\MarketingPlanners;

use App\Http\Resources\Resource;

final class MarketingPlannerTasksResource extends Resource
{
    public static $wrap = null;

    protected function getResponse(): array
    {
        $marketingPlannerTasks = [];

        foreach ($this->resource as $marketingPlannerTask) {
            $marketingPlannerTasks[] = new MarketingPlannerTaskResource($marketingPlannerTask);
        }

        return $marketingPlannerTasks;
    }
}
