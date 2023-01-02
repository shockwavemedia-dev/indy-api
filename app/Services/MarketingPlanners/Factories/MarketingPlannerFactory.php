<?php

declare(strict_types=1);

namespace App\Services\MarketingPlanners\Factories;

use App\Models\MarketingPlanner;
use App\Repositories\Interfaces\MarketingPlannerRepositoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerFactoryInterface;
use App\Services\MarketingPlanners\Resources\MarketingPlannerCreateResource;

final class MarketingPlannerFactory implements MarketingPlannerFactoryInterface
{
    private MarketingPlannerRepositoryInterface $marketingPlannerRepository;

    public function __construct(MarketingPlannerRepositoryInterface $marketingPlannerRepository)
    {
        $this->marketingPlannerRepository = $marketingPlannerRepository;
    }

    public function make(MarketingPlannerCreateResource $resource): MarketingPlanner
    {
        /** @var MarketingPlanner $marketingPlanner */
        $marketingPlanner = $this->marketingPlannerRepository->create([
            'client_id' => $resource->getClient()->getId(),
            'event_name' => $resource->getEventName(),
            'description' => $resource->getDescription(),
            'start_date' => $resource->getStartDate(),
            'end_date' => $resource->getEndDate(),
            'is_recurring' => $resource->isRecurring(),
            'created_by' => $resource->getCreatedBy()->getId(),
        ]);

        return $marketingPlanner;
    }
}
