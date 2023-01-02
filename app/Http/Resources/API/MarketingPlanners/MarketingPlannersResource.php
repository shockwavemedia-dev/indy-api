<?php

declare(strict_types=1);

namespace App\Http\Resources\API\MarketingPlanners;

use App\Http\Resources\Resource;

final class MarketingPlannersResource extends Resource
{
    public static $wrap = null;

    protected function getResponse(): array
    {
        $marketingPlanners = [];

        foreach ($this->resource as $marketingPlanner) {
            $marketingPlanners[] = new MarketingPlannerResource($marketingPlanner);
        }

        return $marketingPlanners;
    }
}
