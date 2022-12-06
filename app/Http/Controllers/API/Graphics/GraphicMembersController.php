<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Graphics;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Departments\StaffsResource;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class GraphicMembersController extends AbstractAPIController
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    ) {
    }

    public function __invoke(): JsonResource
    {
        /** @var Department $department */
        $department = $this->departmentRepository->findByName('Graphics Department');

        $adminUsers = $department?->getAdminUsers() ?? [];
        $filtered = [];

        foreach ($adminUsers as $adminUser) {
            if ($adminUser->getUser() === null) {
                continue;
            }

            $filtered[] = $adminUser;
        }
        
        return new StaffsResource($filtered);
    }
}
