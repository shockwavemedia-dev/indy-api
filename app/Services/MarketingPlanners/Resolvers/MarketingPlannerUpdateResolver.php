<?php

declare(strict_types=1);

namespace App\Services\MarketingPlanners\Resolvers;

use App\Models\MarketingPlanner;
use App\Repositories\Interfaces\MarketingPlannerRepositoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerUpdateResolverInterface;
use App\Services\MarketingPlanners\Resources\MarketingPlannerUpdateResource;

final class MarketingPlannerUpdateResolver implements MarketingPlannerUpdateResolverInterface
{
    private MarketingPlannerRepositoryInterface $marketingPlannerRepository;

    public function __construct(MarketingPlannerRepositoryInterface $marketingPlannerRepository) {
        $this->marketingPlannerRepository = $marketingPlannerRepository;
    }

    public function resolve(
        MarketingPlanner $marketingPlanner,
        MarketingPlannerUpdateResource $resource
    ): MarketingPlanner {
        $marketingPlannerArray = [
            "event_name" => $marketingPlanner->getEventName(),
            "description" => $marketingPlanner->getDescription(),
            "start_date" => $marketingPlanner->getStartDateAsString(),
            "end_date" => $marketingPlanner->getEndDateAsString(),
            "is_recurring" => $marketingPlanner->isRecurring(),
        ];

        $updateRequest = [
            "event_name" => $resource->getEventName(),
            "description" => $resource->getDescription(),
            "start_date" => $resource->getStartDate()?->toDateTimeString(),
            "end_date" => $resource->getEndDate()?->toDateTimeString(),
            "is_recurring" => $resource->isRecurring(),
        ];

        $changes = array_diff($updateRequest, $marketingPlannerArray);

        if (empty($changes) === true) {
            return $marketingPlanner;
        }

        $changes['updated_by'] = $resource->getUpdatedBy()->getId();

        return $this->marketingPlannerRepository->updateMarketingPlanner(
            $marketingPlanner,
            $changes
        );
    }
}
