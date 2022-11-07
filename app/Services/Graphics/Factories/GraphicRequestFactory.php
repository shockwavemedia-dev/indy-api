<?php

declare(strict_types=1);

namespace App\Services\Graphics\Factories;

use App\Enum\TicketTypeEnum;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Services\Graphics\Interfaces\Factories\GraphicRequestFactoryInterface;
use App\Services\Graphics\Resources\CreateGraphicRequestResource;
use App\Services\Tickets\Interfaces\Factories\TicketTypeResolverFactoryInterface;
use App\Services\Tickets\Resources\CreateTicketResource;
use Carbon\Carbon;
use Exception;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

final class GraphicRequestFactory implements GraphicRequestFactoryInterface
{
    private DepartmentRepositoryInterface $departmentRepository;

    private TicketTypeResolverFactoryInterface $ticketTypeResolverFactory;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        TicketTypeResolverFactoryInterface $ticketTypeResolverFactory
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->ticketTypeResolverFactory = $ticketTypeResolverFactory;
    }

    /**
     * @throws Exception
     * @throws UnknownProperties
     */
    public function make(CreateGraphicRequestResource $resource): Ticket
    {
        $ticketCreator = $this->ticketTypeResolverFactory->make(new TicketTypeEnum(TicketTypeEnum::PROJECT));

        $department = $this->departmentRepository->findByName('Graphics Department');

        $dueDate = (new Carbon())->addDays($department?->getMinDeliveryDays() ?? 1);

        return $ticketCreator->create(new CreateTicketResource([
            'client' => $resource->getRequestedBy()->getUserType()?->getClient(),
            'createdBy' => $resource->getRequestedBy(),
            'department' => $department,
            'description' => $resource->getDescription(),
            'dueDate' => $dueDate,
            'requestedBy' => $resource->getRequestedBy(),
            'services' => [$resource->getService()],
            'subject' => 'Graphic request',
            'attachments' => $resource->getAttachments(),
            'type' => new TicketTypeEnum(TicketTypeEnum::GRAPHIC),
        ]));
    }
}
