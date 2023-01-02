<?php

declare(strict_types=1);

namespace App\Services\SupportRequests\Interfaces;

use App\Models\SupportRequest;
use App\Services\SupportRequests\Resources\CreateSupportRequestResource;

interface SupportRequestFactoryInterface
{
    public function make(CreateSupportRequestResource $resource): SupportRequest;
}
