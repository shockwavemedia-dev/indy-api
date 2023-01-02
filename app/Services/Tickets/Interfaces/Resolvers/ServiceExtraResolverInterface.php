<?php

declare(strict_types=1);

namespace App\Services\Tickets\Interfaces\Resolvers;

use App\Models\Service;

interface ServiceExtraResolverInterface
{
    public function resolve(Service $service): array;
}
