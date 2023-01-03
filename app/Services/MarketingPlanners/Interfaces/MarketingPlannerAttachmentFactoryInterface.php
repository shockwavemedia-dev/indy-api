<?php

namespace App\Services\MarketingPlanners\Interfaces;

use App\Models\MarketingPlannerAttachment;
use App\Services\MarketingPlanners\Resources\MarketingPlannerAttachmentCreateResource;

interface MarketingPlannerAttachmentFactoryInterface
{
    public function make(MarketingPlannerAttachmentCreateResource $resource): MarketingPlannerAttachment;
}
