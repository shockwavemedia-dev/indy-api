<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MarketingPlannerAttachment;
use App\Repositories\Interfaces\MarketingPlannerAttachmentRepositoryInterface;

final class MarketingPlannerAttachmentRepository extends BaseRepository implements  MarketingPlannerAttachmentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new MarketingPlannerAttachment());
    }
}
