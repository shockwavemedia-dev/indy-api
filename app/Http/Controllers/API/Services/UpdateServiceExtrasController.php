<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Services;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Services\UpdateServiceExtrasRequest;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdateServiceExtrasController extends AbstractAPIController
{
    private ServiceRepositoryInterface $serviceRepository;

    public function __construct(ServiceRepositoryInterface $serviceRepository) {
        $this->serviceRepository = $serviceRepository;
    }

    public function __invoke(UpdateServiceExtrasRequest $request, int $id)
    {
        $service = $this->serviceRepository->find($id);

        if ($service === null) {
            return $this->respondNotFound();
        }

        $extras = \array_values($request->getExtras());

        $service = $this->serviceRepository->updateServiceExtras($service, $extras);

        return new JsonResponse($service);
    }
}
