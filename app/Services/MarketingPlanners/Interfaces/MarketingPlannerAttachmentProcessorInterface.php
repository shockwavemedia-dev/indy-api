<?php

namespace App\Services\MarketingPlanners\Interfaces;

use App\Models\MarketingPlanner;
use Illuminate\Http\UploadedFile;

interface MarketingPlannerAttachmentProcessorInterface
{
    public function process(MarketingPlanner $marketingPlanner, UploadedFile $file): void;
}
