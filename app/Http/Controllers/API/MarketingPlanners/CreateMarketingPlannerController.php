<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\MarketingPlanners;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\MarketingPlanners\CreateMarketingPlannerRequest;
use App\Http\Resources\API\MarketingPlanners\MarketingPlannerResource;
use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerAttachmentProcessorInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerFactoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerTaskFactoryInterface;
use App\Services\MarketingPlanners\Resources\MarketingPlannerCreateResource;
use App\Services\MarketingPlanners\Resources\MarketingPlannerTaskCreateResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

final class CreateMarketingPlannerController extends AbstractAPIController
{
    private MarketingPlannerAttachmentProcessorInterface $attachmentProcessor;

    private ClientRepositoryInterface $clientRepository;

    private MarketingPlannerFactoryInterface $marketingPlannerFactory;

    private MarketingPlannerTaskFactoryInterface $marketingPlannerTaskFactory;

    public function __construct(
        ClientRepositoryInterface $clientRepository,
        MarketingPlannerAttachmentProcessorInterface $attachmentProcessor,
        MarketingPlannerFactoryInterface $marketingPlannerFactory,
        MarketingPlannerTaskFactoryInterface $marketingPlannerTaskFactory,
    ) {
        $this->attachmentProcessor = $attachmentProcessor;
        $this->clientRepository = $clientRepository;
        $this->marketingPlannerFactory = $marketingPlannerFactory;
        $this->marketingPlannerTaskFactory = $marketingPlannerTaskFactory;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(CreateMarketingPlannerRequest $request, int $id): JsonResource
    {
        $user = $this->getUser();

        /** @var Client $client */
        $client = $this->clientRepository->find($id);

        if ($client->getId() !== $this->getUser()->getUserType()->getClient()->getId()) {
            return $this->respondForbidden();
        }

        $marketingPlanner = $this->marketingPlannerFactory->make(new MarketingPlannerCreateResource([
            'client' => $client,
            'eventName' => $request->getEventName(),
            'description' => $request->getDescription(),
            'startDate' => $request->getStartDate(),
            'endDate' => $request->getEndDate(),
            'isRecurring' => $request->isRecurring(),
            'createdBy' => $user,
        ]));

        foreach ($request->getTodoList() ?? [] as $task) {
            $assignees = Arr::get($task, 'assignees', []) ?? [Arr::get($task, 'assignee', [])];

            $this->marketingPlannerTaskFactory->make(new MarketingPlannerTaskCreateResource([
                'name' => Arr::get($task, 'name') ?? '',
                'assignees' => $assignees,
                'status' => Arr::get($task, 'status') ?? '',
                'deadline' => Arr::get($task, 'deadline') ? new Carbon(Arr::get($task, 'deadline')) : null,
                'marketingPlanner' => $marketingPlanner,
                'notify' => Arr::get($task, 'notify', false),
            ]));
        }

        if ($request->getAttachments() === null) {
            return new JsonResource($marketingPlanner);
        }

        foreach ($request->getAttachments() as $file) {
            $this->attachmentProcessor->process($marketingPlanner, $file);
        }

        $marketingPlanner->refresh();

        return new MarketingPlannerResource($marketingPlanner);
    }
}
