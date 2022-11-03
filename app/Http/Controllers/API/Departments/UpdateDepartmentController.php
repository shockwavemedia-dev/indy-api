<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Departments;

use App\Enum\DepartmentStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Departments\UpdateDepartmentRequest;
use App\Http\Resources\API\Departments\DepartmentResource;
use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Services\Departments\Resources\CreateDepartmentResources;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UpdateDepartmentController extends AbstractAPIController
{
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function __invoke(UpdateDepartmentRequest $request, int $id): JsonResource
    {
        try {
            $status = DepartmentStatusEnum::ACTIVE ?? $request->getStatus();

            /** @var Department $exist */
            $exist = $this->departmentRepository->find($id);

            if ($exist === null) {
                return $this->respondNotFound([
                    'message' => 'Department not found.',
                ]);
            }

            $department = $this->departmentRepository->update($exist, new CreateDepartmentResources([
                'name' => $request->getName() ?? $exist->getName(),
                'description' => $request->getDescription() ?? $exist->getDescription(),
                'status' => new DepartmentStatusEnum($status) ?? $exist->getStatus(),
                'minDeliveryDays' => $request->getMinDeliveryDays() ?? $exist->getMinDeliveryDays(),
                'serviceIds' => $request->getServiceIds(),
            ]));

            return new DepartmentResource($department);
        }  catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
