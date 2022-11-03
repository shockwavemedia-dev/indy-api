<?php

namespace App\Services\MarketingPlanners\Interfaces;

use App\Models\MarketingPlanner;
use App\Services\MarketingPlanners\Resources\MarketingPlannerCreateResource;

interface MarketingPlannerFactoryInterface
{
    public function make(MarketingPlannerCreateResource $resource): MarketingPlanner;
}
