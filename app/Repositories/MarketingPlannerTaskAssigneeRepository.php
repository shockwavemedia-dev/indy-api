<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MarketingPlannerTask;
use App\Models\MarketingPlannerTaskAssignee;
use App\Repositories\Interfaces\MarketingPlannerTaskAssigneeRepositoryInterface;

final class MarketingPlannerTaskAssigneeRepository extends BaseRepository implements MarketingPlannerTaskAssigneeRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new MarketingPlannerTaskAssignee());
    }

    public function deleteByTask(MarketingPlannerTask $marketingPlannerTask): void
    {
        $this->model->where('task_id', $marketingPlannerTask->getId())->delete();
    }

    public function deleteByTaskIds(array $tasksIds): void
    {
        $this->model->whereIn('task_id', $tasksIds)->delete();
    }
}
