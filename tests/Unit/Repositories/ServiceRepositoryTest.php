<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Models\Service;
use App\Repositories\ServiceRepository;
use Tests\TestCase;

/**
 * @covers \App\Repositories\ServiceRepository
 */
final class ServiceRepositoryTest extends TestCase
{
    public function testAllServices(): void
    {
        $service = $this->env->service()->service;

        $repository = new ServiceRepository();

        $results = $repository->all();

        $arrayResults = \json_decode(\json_encode($results), true);

        $this->assertArrayHasKeys(
            [
                'name',
                'extras',
            ],
            $arrayResults['data'][0]
        );
    }

    public function testFindByIds(): void
    {
        $service = $this->env->service()->service;

        $repository = new ServiceRepository();

        $findIds = $repository->findByIds([$service->getId()]);

        /** @var Service $actual */
        $findServiceIds = $findIds->find($service->getId());

        $this->assertNotNull($findServiceIds);
    }

    public function testFindByName(): void
    {
        $service = $this->env->service;

        $repository = new ServiceRepository();

        $result = $repository->findByName($service->getName());

        self::assertEquals($service->getId(), $result->getId());
    }
}
