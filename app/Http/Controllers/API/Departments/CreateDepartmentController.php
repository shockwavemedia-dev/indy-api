<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Departments;

use App\Enum\DepartmentStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Departments\CreateDepartmentRequest;
use App\Http\Resources\API\Departments\DepartmentResource;
use App\Services\Departments\Interfaces\CreateDepartmentServiceInterface;
use App\Services\Departments\Resources\CreateDepartmentResources;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class CreateDepartmentController extends AbstractAPIController
{
    private CreateDepartmentServiceInterface $createDepartmentService;

    public function __construct(CreateDepartmentServiceInterface $createDepartmentService)
    {
        $this->createDepartmentService = $createDepartmentService;
    }

    public function __invoke(CreateDepartmentRequest $request): JsonResource
    {
        try {
            $department = $this->createDepartmentService->create(new CreateDepartmentResources([
                'name' => $request->getName(),
                'description' => $request->getDescription() ?? ' ',
                'status' => new DepartmentStatusEnum(DepartmentStatusEnum::ACTIVE),
                'minDeliveryDays' => $request->getMinDeliveryDays(),
                'serviceIds' => $request->getServiceIds(),
            ]));

            return new DepartmentResource($department);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
