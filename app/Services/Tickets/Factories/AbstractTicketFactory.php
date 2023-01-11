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
use Carbon\Carbon;

abstract class AbstractTicketFactory
{
    protected mixed $bucket;


    public function __construct(
        private BucketFactoryInterface $bucketFactory,
        private DepartmentTicketNotificationHandlerInterface $departmentTicketNotificationHandler,
        private MarketingPlannerAttachmentProcessorInterface $attachmentProcessor,
        private MarketingPlannerFactoryInterface $marketingPlannerFactory,
        private TicketRepositoryInterface $ticketRepository,
        private TicketServicesFactoryInterface $ticketServiceFactory
    ) {
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
            'start_date' => new Carbon(),
            'is_approval_required' => 0,
            'email_html' => json_encode($resource->getEmailHtml()),
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
            'user_notes' => json_encode([
                $resource->getCreatedBy()->getId() => 0,
            ]),
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
            'endDate' => $resource->getMarketingPlannerEndDate(),
            'isRecurring' => false,
            'createdBy' => $resource->getCreatedBy(),
        ]));

        foreach ($resource->getAttachments() ?? [] as $file) {
            $this->attachmentProcessor->process($marketingPlanner, $file);
        }

        return $ticket;
    }
}
