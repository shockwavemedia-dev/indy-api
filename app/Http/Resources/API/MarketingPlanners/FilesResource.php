<?php

declare(strict_types=1);

namespace App\Http\Resources\API\MarketingPlanners;

use App\Http\Resources\Resource;
use App\Models\MarketingPlannerAttachment;

final class FilesResource extends Resource
{
    protected function getResponse(): array
    {
        $files = [];

        /** @var MarketingPlannerAttachment $attachment */
        foreach ($this->resource as $attachment) {
            $files[] = new FileResource($attachment->getFile());
        }

        return $files;
    }
}
