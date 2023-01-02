<?php

declare(strict_types=1);

namespace App\Services\MarketingPlanners\Resources;

use App\Models\File;
use App\Models\MarketingPlanner;
use Spatie\DataTransferObject\DataTransferObject;

final class MarketingPlannerAttachmentCreateResource extends DataTransferObject
{
    public File $file;

    public MarketingPlanner $marketingPlanner;

    public function getFile(): File
    {
        return $this->file;
    }

    public function getMarketingPlanner(): MarketingPlanner
    {
        return $this->marketingPlanner;
    }
}
