<?php

declare(strict_types=1);

namespace App\Services\Tickets\Factories;

use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Services\Departments\Interfaces\DepartmentTicketNotificationHandlerInterface;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerAttachmentProcessorInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerFactoryInterface;
use App\Services\Tickets\Interfaces\Factories\TicketServicesFactoryInterface;
use App\Services\Tickets\Interfaces\Resolvers\TicketTypeResolverInterface;
use App\Services\Tickets\Resources\CreateTicketResource;

final class GenericTicketFactory extends AbstractTicketFactory implements TicketTypeResolverInterface
{
    private const STATUS = TicketStatusEnum::NEW;

    private TicketRepositoryInterface $repository;

    public function __construct(
        BucketFactoryInterface $bucketFactory,
        DepartmentTicketNotificationHandlerInterface $departmentTicketNotificationHandler,
        TicketRepositoryInterface $repository,
        TicketServicesFactoryInterface $ticketServiceFactory,
        MarketingPlannerAttachmentProcessorInterface $attachmentProcessor,
        MarketingPlannerFactoryInterface $marketingPlannerFactory,
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
     */
    public function create(CreateTicketResource $resource): Ticket
    {
        return $this->make($resource);
    }

    public function supports(TicketTypeEnum $type): bool
    {
        $ticketTypes = [
            TicketTypeEnum::GRAPHIC,
            TicketTypeEnum::PRINT,
            TicketTypeEnum::TASK,
            TicketTypeEnum::LIBRARY,
        ];

        return in_array($type->getValue(), $ticketTypes, true) === true;
    }
}
