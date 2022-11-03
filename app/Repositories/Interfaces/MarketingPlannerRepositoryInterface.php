<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\MarketingPlanner;
use App\Services\MarketingPlanners\Resources\MarketingPlannerUpdateResource;
use Illuminate\Database\Eloquent\Collection;

interface MarketingPlannerRepositoryInterface
{
    public function findAllByClient(Client $client): Collection;

    public function updateMarketingPlanner(
        MarketingPlanner $marketingPlanner,
        array $changes
    ): MarketingPlanner;
}
