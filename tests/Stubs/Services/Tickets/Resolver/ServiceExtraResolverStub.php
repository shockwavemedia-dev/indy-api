<?php

declare(strict_types=1);

namespace Tests\Stubs\Services\Tickets\Resolver;

use App\Models\Service;
use App\Services\Tickets\Interfaces\Resolvers\ServiceExtraResolverInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class ServiceExtraResolverStub extends AbstractStub implements  ServiceExtraResolverInterface
{
    /**
     * @throws \Throwable
     */
    public function resolve(Service $service): array
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
