<?php

namespace Database\Seeders;

use App\Enum\DepartmentStatusEnum;
use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\Department;
use App\Services\Departments\Interfaces\CreateDepartmentServiceInterface;
use App\Services\Departments\Resources\CreateDepartmentResources;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Throwable;

final class DepartmentsSeeder extends Seeder
{
    /**
     * @var string[]
     */
    private const DEPARTMENTS = [
        'Animation Department',
        'Graphics Department',
        'Printer Department',
        'Payroll Department',
        'Video Production',
        'Social Media',
        'Website Department',
        'Accounts',
        'Advertising Department',
        'Customer Support',
        'Photographer',
    ];

    private CreateDepartmentServiceInterface $createDepartmentService;

    private ErrorLogInterface $sentryHandler;

    public function __construct(
        CreateDepartmentServiceInterface $createDepartmentService,
        ErrorLogInterface $sentryHandler
    ) {
        $this->createDepartmentService = $createDepartmentService;
        $this->sentryHandler = $sentryHandler;
    }

    public function run(): void
    {
        try {
            $departments = Department::all();

            $departmentsName = [];

            foreach ($departments as $departmentModel) {
                $departmentsName[] = $departmentModel->getName();
            }

            foreach (self::DEPARTMENTS as $department) {
                if (\in_array($department, $departmentsName)) {
                    continue;
                }

                $this->createDepartmentService->create(new CreateDepartmentResources([
                    'name' => $department,
                    'description' => $department,
                    'status' => new DepartmentStatusEnum(DepartmentStatusEnum::ACTIVE),
                    'minDeliveryDays' => 7,
                ]));
            }
        }  catch (Throwable $throwable) {
            $this->command->info($throwable->getMessage());
            $this->sentryHandler->reportError($throwable);
        }
    }
}
