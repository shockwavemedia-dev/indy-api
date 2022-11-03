<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MarketingPlanner;
use App\Models\MarketingPlannerTask;
use App\Repositories\Interfaces\MarketingPlannerTaskRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

final class MarketingPlannerTaskRepository extends BaseRepository implements MarketingPlannerTaskRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new MarketingPlannerTask());
    }

    public function deleteByMarketingPlannerAndIds(MarketingPlanner $marketingPlanner, array $ids): void
    {
            $this->model->where('marketing_planner_id', $marketingPlanner->getId())
            ->whereNotIn('id', $ids)
            ->delete();
    }

    public function findByMarketingPlannerAndId(MarketingPlanner $marketingPlanner, int $id): ?MarketingPlannerTask
    {
        return $this->model->where('id', $id)
            ->where('marketing_planner_id', $marketingPlanner->getId())
            ->first();
    }
}
