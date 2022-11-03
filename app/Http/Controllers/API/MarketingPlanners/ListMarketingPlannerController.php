<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\MarketingPlanners;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\MarketingPlanners\MarketingPlannersResource;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\MarketingPlannerRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListMarketingPlannerController extends AbstractAPIController
{
    private MarketingPlannerRepositoryInterface $marketingPlannerRepository;
    private ClientRepositoryInterface $clientRepository;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        MarketingPlannerRepositoryInterface $marketingPlannerRepository
    ) {
        $this->clientRepository = $clientRepository;
        $this->marketingPlannerRepository = $marketingPlannerRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $client = $this->clientRepository->find($id);

        if ($client === null) {
            return $this->respondNotFound([
                'message' => 'Client not found.',
            ]);
        }

        if ($client->getId() !== $this->getUser()->getUserType()->getClient()->getId()) {
            return $this->respondForbidden();
        }


        return new MarketingPlannersResource($this->marketingPlannerRepository->findAllByClient($client));
    }
}
