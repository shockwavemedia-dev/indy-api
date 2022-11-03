<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories;

use App\Enum\DepartmentStatusEnum;
use App\Models\Department;
use App\Repositories\DepartmentRepository;
use App\Services\Departments\Resources\CreateDepartmentResources;
use App\Services\Users\Exceptions\InvalidDepartmentsException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Tests\TestCase;

/**
 * @covers \App\Repositories\DepartmentRepository
 */
final class DepartmentRepositoryTest extends TestCase
{
    public function testDeleteDepartment(): void
    {
        $department = $this->env->department()->department;

        $repository = new DepartmentRepository();

        $repository->deleteDepartment($department);

        $department->refresh();

        $this->assertEquals(DepartmentStatusEnum::DELETED, $department->getStatus()->getValue());
    }

    /**
     * @throws UnknownProperties
     * @throws InvalidDepartmentsException
     */
    public function testUpdateDepartmentSuccess(): void
    {
        $department = $this->env->department()->department;

        $updateResource = new CreateDepartmentResources([
            'name' => 'Graphics Department',
            'description' => 'for graphics department',
            'minDeliveryDays' => 1,
            'status' => new DepartmentStatusEnum(DepartmentStatusEnum::ACTIVE)
        ]);

        $repository = new DepartmentRepository();

        $expected = [
            'name' => 'Graphics Department',
            'description' => 'for graphics department',
            'minDeliveryDays' => 1,
            'status' => new DepartmentStatusEnum(DepartmentStatusEnum::ACTIVE),
        ];

        $department = $repository->update($department, $updateResource);

        $department->refresh();

        $actual = [
            'name' => $department->getName(),
            'description' => $department->getDescription(),
            'minDeliveryDays' => $department->getMinDeliveryDays(),
            'status' => $department->getStatus(),
        ];

        self::assertEquals($expected, $actual);
    }

    public function testAll(): void
    {
        $department = $this->env->department;

        $repository = new DepartmentRepository();

        $results = $repository->all(500);

        $departmentIds = array_column($results->toArray()['data'], 'id' );

        self::assertContains($department->getId(), $departmentIds);
    }

    public function testCount(): void
    {
        $department = $this->env->department;

        $repository = new DepartmentRepository();

        $count = $repository->countDepartments([$department->getId()]);

        self::assertEquals(1, $count);
    }
}
