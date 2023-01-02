<?php

declare(strict_types=1);

namespace App\Services\MarketingPlanners\Resolvers;

use App\Models\MarketingPlanner;
use App\Models\MarketingPlannerTaskAssignee;
use App\Repositories\Interfaces\MarketingPlannerTaskAssigneeRepositoryInterface;
use App\Repositories\Interfaces\MarketingPlannerTaskRepositoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerTaskFactoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerTaskUpdateResolverInterface;
use App\Services\MarketingPlanners\Resources\MarketingPlannerTaskCreateResource;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class MarketingPlannerTaskUpdateResolver implements MarketingPlannerTaskUpdateResolverInterface
{
    private MarketingPlannerTaskRepositoryInterface $marketingPlannerTaskRepository;

    private MarketingPlannerTaskFactoryInterface $marketingPlannerTaskFactory;

    private MarketingPlannerTaskAssigneeRepositoryInterface $marketingPlannerTaskAssigneeRepository;

    public function __construct(
        MarketingPlannerTaskRepositoryInterface $marketingPlannerTaskRepository,
        MarketingPlannerTaskFactoryInterface $marketingPlannerTaskFactory,
        MarketingPlannerTaskAssigneeRepositoryInterface $marketingPlannerTaskAssigneeRepository,
    ) {
        $this->marketingPlannerTaskRepository = $marketingPlannerTaskRepository;
        $this->marketingPlannerTaskFactory = $marketingPlannerTaskFactory;
        $this->marketingPlannerTaskAssigneeRepository = $marketingPlannerTaskAssigneeRepository;
    }

    /**
     * @throws UnknownProperties
     * @throws \Exception
     */
    public function resolve(
        MarketingPlanner $marketingPlanner,
        array $marketingPlannerTasks
    ): void {
        $existingIds = array_column($marketingPlannerTasks, 'id');

        $this->marketingPlannerTaskAssigneeRepository->deleteByTaskIds($existingIds);

        $this->marketingPlannerTaskRepository->deleteByMarketingPlannerAndIds($marketingPlanner, $existingIds);

        foreach ($marketingPlannerTasks as $marketingPlannerTask) {
            if (empty($marketingPlannerTask['deadline']) === false) {
                $marketingPlannerTask['deadline'] = (new Carbon($marketingPlannerTask['deadline']))->toDateString();
            }

            $assignees = Arr::get($marketingPlannerTask, 'assignees', []) ?? [Arr::get($marketingPlannerTask, 'assignee', [])];

            if (Arr::get($marketingPlannerTask, 'id') === null) {
                $this->marketingPlannerTaskFactory->make(new MarketingPlannerTaskCreateResource([
                    'name' => Arr::get($marketingPlannerTask, 'name'),
                    'assignees' => $assignees,
                    'status' => Arr::get($marketingPlannerTask, 'status', 'Todo'),
                    'deadline' => Arr::get($marketingPlannerTask, 'deadline')
                    ? (new Carbon(Arr::get($marketingPlannerTask, 'deadline'))) : null,
                    'notify' => Arr::get($marketingPlannerTask, 'notify', false),
                    'marketingPlanner' => $marketingPlanner,
                ]));

                continue;
            }

            $taskExist = $this->marketingPlannerTaskRepository->findByMarketingPlannerAndId(
                $marketingPlanner,
                Arr::get($marketingPlannerTask, 'id')
            );

            if ($taskExist === null) {
                throw new \Exception(
                    'Bad data, marketing planner not related to the marketing planner task.'
                );
            }

            $taskExist->update($marketingPlannerTask);

            foreach ($assignees as $assignee) {
                MarketingPlannerTaskAssignee::create([
                    'user_id' => $assignee,
                    'task_id' => $taskExist->getId(),
                ]);
            }
        }
    }
}
