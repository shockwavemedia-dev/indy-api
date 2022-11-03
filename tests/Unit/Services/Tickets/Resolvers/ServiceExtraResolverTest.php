<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Tickets\Resolvers;

use App\Enum\ServiceExtraEnum;
use App\Enum\ServicesEnum;
use App\Models\Service;
use App\Services\Tickets\Resolvers\ServiceExtraResolver;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Services\Tickets\Resolvers\ServiceExtraResolver
 */
final class ServiceExtraResolverTest extends TestCase
{
    public function testResolveSuccess(): void
    {
        $resolver = new ServiceExtraResolver();

        $service = new Service();

        $service->setAttribute('name', ServicesEnum::GRAPHIC_DESIGN);

        $extras = $resolver->resolve($service);

        self::assertEquals(ServiceExtraEnum::EXTRAS[ServicesEnum::GRAPHIC_DESIGN], $extras);
    }

    public function testResolveEmptyArray(): void
    {
        $resolver = new ServiceExtraResolver();
        $service = new Service();
        $service->setAttribute('name', 'Invalid Test');
        $extras = $resolver->resolve($service);

        self::assertEquals([], $extras);
    }
}
