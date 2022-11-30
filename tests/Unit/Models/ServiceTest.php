<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Service;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\Service
 */
final class ServiceTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'Graphic Design',
        ];

        $service = new Service();
        $service->setAttribute('id', 1);
        $service->setAttribute('name', 'Graphic Design');

        $actual = [
            'id' => $service->getId(),
            'name' => $service->getName(),
        ];

        self::assertEquals($expected, $actual);
    }
}
