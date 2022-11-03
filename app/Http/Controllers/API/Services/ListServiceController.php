<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Services;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Http\Resources\API\Services\ServicesResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ListServiceController extends AbstractAPIController
{
    private ServiceRepositoryInterface $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function __invoke(PaginationRequest $request): JsonResource
    {
        try {
            $service = $this->serviceRepository->all(
                $request->getSize(),
                $request->getPageNumber()
            );

            return new ServicesResource($service);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
