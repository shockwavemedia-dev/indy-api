<?php

declare(strict_types=1);

namespace App\Services\Tickets\Resolvers;

use App\Enum\ServiceExtraEnum;
use App\Models\Service;
use App\Services\Tickets\Interfaces\Resolvers\ServiceExtraResolverInterface;
use Illuminate\Support\Arr;

final class ServiceExtraResolver implements ServiceExtraResolverInterface
{
    public function resolve(Service $service): array
    {
        return Arr::get(ServiceExtraEnum::EXTRAS, $service->getName(), []);
    }
}
