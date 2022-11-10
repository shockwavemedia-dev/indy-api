<?php

declare(strict_types=1);

namespace App\Services\Tickets\Factories;

use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketEventRepositoryInterface;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\Departments\Interfaces\DepartmentTicketNotificationHandlerInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerAttachmentProcessorInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerFactoryInterface;
use App\Services\Tickets\Interfaces\Factories\TicketServicesFactoryInterface;
use App\Services\Tickets\Interfaces\Resolvers\TicketTypeResolverInterface;
use App\Services\Tickets\Resources\CreateTicketResource;

final class EmailTicketFactory extends AbstractTicketFactory implements TicketTypeResolverInterface
{
    private const STATUS = TicketStatusEnum::NEW;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        DepartmentTicketNotificationHandlerInterface $departmentTicketNotificationHandler,
        TicketRepositoryInterface $repository,
        TicketServicesFactoryInterface $ticketServiceFactory,
        MarketingPlannerAttachmentProcessorInterface $attachmentProcessor,
        MarketingPlannerFactoryInterface $marketingPlannerFactory,
        private TicketEventRepositoryInterface $ticketEventRepository,
    ) {
        parent::__construct(
            $bucketFactory,
            $departmentTicketNotificationHandler,
            $attachmentProcessor,
            $marketingPlannerFactory,
            $repository,
            $ticketServiceFactory
        );
    }

    /**
     * @throws \App\Services\FileManager\Exceptions\BucketNameExistsException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function create(CreateTicketResource $resource): Ticket
    {
        $ticket = $this->make($resource);

        $this->ticketEventRepository->create([
            'ticket_id' => $ticket->getId(),
        ]);

        return $ticket;
    }

    public function supports(TicketTypeEnum $type): bool
    {
        if (TicketTypeEnum::EMAIL !== $type->getValue()) {
            return false;
        }

        return true;
    }
}
