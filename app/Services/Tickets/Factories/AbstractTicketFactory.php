<?php

declare(strict_types=1);

namespace App\Services\Tickets\Factories;

use App\Enum\TicketNotificationTypeEnum;
use App\Enum\TicketStatusEnum;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\Departments\Interfaces\DepartmentTicketNotificationHandlerInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerAttachmentProcessorInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerFactoryInterface;
use App\Services\MarketingPlanners\Resources\MarketingPlannerCreateResource;
use App\Services\Tickets\Interfaces\Factories\TicketServicesFactoryInterface;
use App\Services\Tickets\Resources\CreateTicketResource;
use Google\Cloud\Storage\Bucket;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class AbstractTicketFactory
{
    protected mixed $bucket;

    private BucketFactoryInterface $bucketFactory;

    private DepartmentTicketNotificationHandlerInterface $departmentTicketNotificationHandler;

    private MarketingPlannerFactoryInterface $marketingPlannerFactory;

    private TicketRepositoryInterface $ticketRepository;

    private TicketServicesFactoryInterface $ticketServiceFactory;

    private MarketingPlannerAttachmentProcessorInterface $attachmentProcessor;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        DepartmentTicketNotificationHandlerInterface $departmentTicketNotificationHandler,
        MarketingPlannerAttachmentProcessorInterface $attachmentProcessor,
        MarketingPlannerFactoryInterface $marketingPlannerFactory,
        TicketRepositoryInterface $ticketRepository,
        TicketServicesFactoryInterface $ticketServiceFactory
    ) {
        $this->attachmentProcessor = $attachmentProcessor;
        $this->bucketFactory = $bucketFactory;
        $this->departmentTicketNotificationHandler = $departmentTicketNotificationHandler;
        $this->marketingPlannerFactory = $marketingPlannerFactory;
        $this->ticketRepository = $ticketRepository;
        $this->ticketServiceFactory = $ticketServiceFactory;
    }

    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function make(CreateTicketResource $resource): Ticket
    {
        $client = $resource->getClient();

        $this->bucket = $this->bucketFactory->make($client->getClientCode());

        $ticketCount = $this->ticketRepository->countTicketByClient($client) + 1;

        $ticketCode = \sprintf('%s-%s', $client->getClientCode(), $ticketCount);

        $ticket = $this->ticketRepository->create([
            'priority' => $resource->getPriority()->getValue(),
            'client_id' => $client->getId(),
            'created_by' => $resource->getCreatedBy()->getId(),
            'created_by_user_type' => $resource->getUserType(),
            'requested_by' => $resource->getRequestedBy()->getId(),
            'description' => $resource->getDescription(),
            'department_id' => $resource->getDepartment()?->getId(),
            'subject' => $resource->getSubject(),
            'ticket_code' => $ticketCode,
            'type' => $resource->getType(),
            'status' => TicketStatusEnum::NEW,
            'duedate' => $resource->getDueDate(),
        ]);

        // Notification Process
        if (\count($resource->getServices()) === 0 && $ticket->getDepartment() !== null) {
            $this->departmentTicketNotificationHandler->handle(
                $ticket->getDepartment(),
                $ticket,
                new TicketNotificationTypeEnum(TicketNotificationTypeEnum::CREATED)
            );

            return $ticket;
        }

        $this->ticketServiceFactory->make(
            $client->getClientServices(),
            $ticket,
            $resource->getCreatedBy(),
            $resource->getServices()
        );

        if ($resource->getMarketingPlannerStartDate() === null) {
            return $ticket;
        }

        $marketingPlanner = $this->marketingPlannerFactory->make(new MarketingPlannerCreateResource([
            'client' => $client,
            'eventName' => $resource->getSubject(),
            'description' => $resource->getDescription(),
            'startDate' => $resource->getMarketingPlannerStartDate(),
            'endDate' => $resource->getMarketingPlannerStartDate(),
            'isRecurring' => false,
            'createdBy' => $resource->getCreatedBy(),
        ]));

        foreach ($resource->getAttachments() ?? [] as $file) {
            $this->attachmentProcessor->process($marketingPlanner, $file);
        }

        return $ticket;

    }
}
