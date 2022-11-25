<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Departments\StaffsResource;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class SocialMediaMemberController extends AbstractAPIController
{
    public function __construct(
        private DepartmentRepositoryInterface $departmentRepository
    ) {}

    public function __invoke(): JsonResource
    {
        /** @var Department $department */
        $department = $this->departmentRepository->findByName('Social Media');

        return new StaffsResource($department?->getAdminUsers() ?? []);
    }
}
