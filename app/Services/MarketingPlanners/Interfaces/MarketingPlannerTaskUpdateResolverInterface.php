<?php

namespace App\Services\MarketingPlanners\Interfaces;

use App\Models\MarketingPlanner;

interface MarketingPlannerTaskUpdateResolverInterface
{
    public function resolve(MarketingPlanner $marketingPlanner, array $marketingPlannerTasks): void;
}
