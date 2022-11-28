<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Departments;

use App\Enum\DepartmentStatusEnum;
use App\Services\Departments\CreateDepartmentService;
use App\Services\Departments\Resources\CreateDepartmentResources;
use Tests\Stubs\Repositories\DepartmentRepositoryStub;
use Tests\TestCase;

/**
 * @covers \App\Services\Departments\CreateDepartmentService
 */
final class CreateDepartmentServiceTest extends TestCase
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function testCreateSuccess(): void
    {
        $department = $this->env->department;

        $departmentRepository = new DepartmentRepositoryStub([
            'create' => $department,
        ]);

        $resource = new CreateDepartmentResources([
            'name' => 'Graphics Department',
            'description' => 'graphics',
            'status' => new DepartmentStatusEnum(DepartmentStatusEnum::ACTIVE),
            'minDeliveryDays' => 7,
        ]);

        $resolver = new CreateDepartmentService(
            $departmentRepository
        );

        $expectedCall = [
            [
                'create' => [
                    [
                        'name' => 'Graphics Department',
                        'description' => 'graphics',
                        'status' => new DepartmentStatusEnum(DepartmentStatusEnum::ACTIVE),
                        'min_delivery_days' => 7,
                    ],
                ],
            ],
        ];

        $resolver->create($resource);

        $this->assertEquals($expectedCall, $departmentRepository->getCalls());
    }
}
