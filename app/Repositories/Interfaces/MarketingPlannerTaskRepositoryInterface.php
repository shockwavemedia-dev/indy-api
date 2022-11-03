<?php

namespace App\Repositories\Interfaces;

use App\Models\MarketingPlanner;
use App\Models\MarketingPlannerTask;

interface MarketingPlannerTaskRepositoryInterface
{
    public function deleteByMarketingPlannerAndIds(MarketingPlanner $marketingPlanner, array $ids): void;

    public function findByMarketingPlannerAndId(
        MarketingPlanner $marketingPlanner,
        int $id
    ): ?MarketingPlannerTask;
}
