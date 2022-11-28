<?php

declare(strict_types=1);

namespace App\Services\MarketingPlanners\Factories;

use App\Models\MarketingPlannerAttachment;
use App\Repositories\Interfaces\MarketingPlannerAttachmentRepositoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerAttachmentFactoryInterface;
use App\Services\MarketingPlanners\Resources\MarketingPlannerAttachmentCreateResource;

final class MarketingPlannerAttachmentFactory implements MarketingPlannerAttachmentFactoryInterface
{
    private MarketingPlannerAttachmentRepositoryInterface $marketingPlannerAttachmentRepository;

    public function __construct(MarketingPlannerAttachmentRepositoryInterface $marketingPlannerAttachmentRepository)
    {
        $this->marketingPlannerAttachmentRepository = $marketingPlannerAttachmentRepository;
    }

    public function make(MarketingPlannerAttachmentCreateResource $resource): MarketingPlannerAttachment
    {
        /** @var MarketingPlannerAttachment $marketingPlannerAttachment */
        $marketingPlannerAttachment = $this->marketingPlannerAttachmentRepository->create([
            'file_id' => $resource->getFile()->getId(),
            'marketing_planner_id' => $resource->getMarketingPlanner()->getId(),
        ]);

        return $marketingPlannerAttachment;
    }
}
