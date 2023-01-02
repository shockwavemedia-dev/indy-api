<?php

namespace App\Services\MarketingPlanners\Interfaces;

use App\Models\MarketingPlanner;
use App\Services\MarketingPlanners\Resources\MarketingPlannerUpdateResource;

interface MarketingPlannerUpdateResolverInterface
{
    public function resolve(
        MarketingPlanner $marketingPlanner,
        MarketingPlannerUpdateResource $resource
    ): MarketingPlanner;
}
