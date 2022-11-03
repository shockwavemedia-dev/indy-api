<?php

declare(strict_types=1);

namespace App\Services\MarketingPlanners\Factories;

use App\Models\MarketingPlannerTask;
use App\Models\MarketingPlannerTaskAssignee;
use App\Repositories\Interfaces\MarketingPlannerTaskRepositoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerTaskFactoryInterface;
use App\Services\MarketingPlanners\Resources\MarketingPlannerTaskCreateResource;

final class MarketingPlannerTaskFactory implements MarketingPlannerTaskFactoryInterface
{
    private MarketingPlannerTaskRepositoryInterface $marketingPlannerTaskRepository;

    public function __construct(MarketingPlannerTaskRepositoryInterface $marketingPlannerTaskRepository) {
        $this->marketingPlannerTaskRepository = $marketingPlannerTaskRepository;
    }
    public function make(MarketingPlannerTaskCreateResource $resource): MarketingPlannerTask
    {
        /** @var MarketingPlannerTask $marketingPlannerTask */
        $marketingPlannerTask = $this->marketingPlannerTaskRepository->create([
            'name' => $resource->getName(),
            'deadline' => $resource->getDeadline(),
            'status' => $resource->getStatus(),
            'marketing_planner_id' => $resource->getMarketingPlanner()->getId(),
            'notify' => $resource->getNotify() ?? false,
        ]);

        // @TODO separate service and repository
        foreach ($resource->getAssignees() as $assignee) {
            MarketingPlannerTaskAssignee::create([
                'user_id' => $assignee,
                'task_id' => $marketingPlannerTask->getId(),
            ]);
        }

        return $marketingPlannerTask;
    }
}
