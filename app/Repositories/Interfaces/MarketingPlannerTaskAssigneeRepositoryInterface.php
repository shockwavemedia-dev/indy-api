<?php

namespace App\Repositories\Interfaces;

use App\Models\MarketingPlannerTask;

interface MarketingPlannerTaskAssigneeRepositoryInterface
{
    public function deleteByTask(MarketingPlannerTask $marketingPlannerTask): void;

    public function deleteByTaskIds(array $tasksIds): void;
}
