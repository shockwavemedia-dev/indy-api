<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Services;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Services\UpdateServiceExtrasRequest;
use App\Repositories\Interfaces\ClientServiceRepositoryInterface;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdateServiceExtrasController extends AbstractAPIController
{
    public function __construct(
        private ClientServiceRepositoryInterface $clientServiceRepository,
        private ServiceRepositoryInterface $serviceRepository
    ) {
    }

    public function __invoke(UpdateServiceExtrasRequest $request, int $id)
    {
        $service = $this->serviceRepository->find($id);

        if ($service === null) {
            return $this->respondNotFound();
        }

        $extras = \array_values($request->getExtras());

        $service = $this->serviceRepository->updateServiceExtras($service, $extras);

        $this->clientServiceRepository->updateClientsExtrasByService($service);

        return new JsonResponse($service);
    }
}
