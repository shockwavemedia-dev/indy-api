<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\MarketingPlanners;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\MarketingPlanner;
use App\Repositories\Interfaces\MarketingPlannerRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeleteMarketingPlannerController extends AbstractAPIController
{
    private MarketingPlannerRepositoryInterface $marketingPlannerRepository;

    public function __construct(
        MarketingPlannerRepositoryInterface $marketingPlannerRepository
    ) {
        $this->marketingPlannerRepository = $marketingPlannerRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(int $id): JsonResource
    {
        /** @var MarketingPlanner $marketingPlanner */
        $marketingPlanner = $this->marketingPlannerRepository->find($id);

        if ($marketingPlanner === null) {
            return $this->respondNoContent();
        }

        if ($marketingPlanner->getClient()->getId() !== $this->getUser()->getUserType()->getClient()->getId()) {
            return $this->respondNoContent();
        }

        $marketingPlanner->delete();

        return $this->respondNoContent();
    }
}
