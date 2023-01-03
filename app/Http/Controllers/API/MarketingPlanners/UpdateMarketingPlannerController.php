<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\MarketingPlanners;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\MarketingPlanners\UpdateMarketingPlannerRequest;
use App\Http\Resources\API\MarketingPlanners\MarketingPlannerResource;
use App\Models\MarketingPlanner;
use App\Repositories\Interfaces\MarketingPlannerRepositoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerTaskUpdateResolverInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerUpdateResolverInterface;
use App\Services\MarketingPlanners\Resources\MarketingPlannerUpdateResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdateMarketingPlannerController extends AbstractAPIController
{
    private MarketingPlannerRepositoryInterface $marketingPlannerRepository;

    private MarketingPlannerUpdateResolverInterface $marketingPlannerUpdateResolver;

    private MarketingPlannerTaskUpdateResolverInterface $marketingPlannerTaskUpdateResolver;

    public function __construct(
        MarketingPlannerRepositoryInterface $marketingPlannerRepository,
        MarketingPlannerUpdateResolverInterface $marketingPlannerUpdateResolver,
        MarketingPlannerTaskUpdateResolverInterface $marketingPlannerTaskUpdateResolver
    ) {
        $this->marketingPlannerRepository = $marketingPlannerRepository;
        $this->marketingPlannerUpdateResolver = $marketingPlannerUpdateResolver;
        $this->marketingPlannerTaskUpdateResolver = $marketingPlannerTaskUpdateResolver;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(UpdateMarketingPlannerRequest $request, int $id): JsonResource
    {
        /** @var MarketingPlanner $marketingPlanner */
        $marketingPlanner = $this->marketingPlannerRepository->find($id);

        if ($marketingPlanner === null) {
            return $this->respondNotFound([
                'message' => 'Marketing Planner not found.',
            ]);
        }

        if ($marketingPlanner->getClient()->getId() !== $this->getUser()->getUserType()->getClient()->getId()) {
            return $this->respondForbidden();
        }

        $marketingPlanner = $this->marketingPlannerUpdateResolver->resolve(
            $marketingPlanner,
            new MarketingPlannerUpdateResource([
                'eventName' => $request->getEventName(),
                'description' => $request->getDescription(),
                'startDate' => $request->getStartDate(),
                'endDate' => $request->getEndDate(),
                'isRecurring' => $request->isRecurring(),
                'updatedBy' => $this->getUser(),
            ])
        );

        $this->marketingPlannerTaskUpdateResolver->resolve(
            $marketingPlanner,
            $request->getTodoList()
        );

        return new MarketingPlannerResource($marketingPlanner);
    }
}
