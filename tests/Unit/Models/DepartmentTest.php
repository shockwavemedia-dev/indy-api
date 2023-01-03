<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Enum\DepartmentStatusEnum;
use App\Models\Department;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Models\Client
 */
final class DepartmentTest extends TestCase
{
    public function testGetterAndSetters(): void
    {
        $expected = [
            'id' => 1,
            'name' => 'Graphics Department',
            'description' => 'for graphics department',
            'min_delivery_days' => 2,
            'status' => DepartmentStatusEnum::ACTIVE,
        ];

        $department = new Department();
        $department->setAttribute('id', 1);
        $department->setName('Graphics Department');
        $department->setDescription('for graphics department');
        $department->setMinimumDeliveryDays(2);
        $department->setStatus(new DepartmentStatusEnum(DepartmentStatusEnum::ACTIVE));

        $actual = [
            'id' => $department->getId(),
            'name' => $department->getName(),
            'description' => $department->getDescription(),
            'min_delivery_days' => $department->getMinDeliveryDays(),
            'status' => $department->getStatus(),
        ];

        self::assertEquals($expected, $actual);
    }
}
