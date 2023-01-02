<?php

namespace App\Services\MarketingPlanners\Interfaces;

use App\Models\MarketingPlannerTask;
use App\Services\MarketingPlanners\Resources\MarketingPlannerTaskCreateResource;

interface MarketingPlannerTaskFactoryInterface
{
    public function make(MarketingPlannerTaskCreateResource $resource): MarketingPlannerTask;
}
