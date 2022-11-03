<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\MarketingPlanners;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\MarketingPlannerTaskRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class RemoveMarketingPlannerTaskController extends AbstractAPIController
{
    private MarketingPlannerTaskRepositoryInterface $marketingPlannerTaskRepository;

    public function __construct(MarketingPlannerTaskRepositoryInterface $marketingPlannerTaskRepository) {
        $this->marketingPlannerTaskRepository = $marketingPlannerTaskRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $task = $this->marketingPlannerTaskRepository->find($id);

        if ($task === null) {
            return $this->respondNoContent();
        }

        $this->marketingPlannerTaskRepository->delete($task);

        return $this->respondNoContent();
    }
}
