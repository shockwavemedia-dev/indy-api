<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Graphics;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Departments\StaffsResource;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class GraphicStaffController extends AbstractAPIController
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    ) {}

    public function __invoke(): JsonResource
    {
        $department = $this->departmentRepository->findByName('Graphics Department');

        return new StaffsResource($department->getStaffs());
    }
}
