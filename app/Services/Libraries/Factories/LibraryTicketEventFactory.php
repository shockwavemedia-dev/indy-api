<?php

declare(strict_types=1);

namespace App\Services\Libraries\Factories;

use App\Enum\TicketPrioritiesEnum;
use App\Enum\TicketTypeEnum;
use App\Models\Tickets\Ticket;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use App\Repositories\Interfaces\LibraryRepositoryInterface;
use App\Services\Libraries\Exceptions\LibraryNotFoundException;
use App\Services\Libraries\Interfaces\Factories\LibraryTicketEventFactoryInterface;
use App\Services\Libraries\Resources\CreateLibraryTicketEventResource;
use App\Services\Tickets\Interfaces\Factories\TicketEventAttachmentFactoryInterface;
use App\Services\Tickets\Interfaces\Factories\TicketTypeResolverFactoryInterface;
use App\Services\Tickets\Resources\CreateTicketEventAttachmentResource;
use App\Services\Tickets\Resources\CreateTicketResource;
use Carbon\Carbon;

final class LibraryTicketEventFactory implements LibraryTicketEventFactoryInterface
{
    private DepartmentRepositoryInterface $departmentRepository;

    private LibraryRepositoryInterface $libraryRepository;

    private TicketTypeResolverFactoryInterface $ticketTypeResolverFactory;

    private TicketEventAttachmentFactoryInterface $ticketEventAttachmentFactory;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        LibraryRepositoryInterface $libraryRepository,
        TicketTypeResolverFactoryInterface $ticketTypeResolverFactory,
        TicketEventAttachmentFactoryInterface $ticketEventAttachmentFactory
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->libraryRepository = $libraryRepository;
        $this->ticketTypeResolverFactory = $ticketTypeResolverFactory;
        $this->ticketEventAttachmentFactory = $ticketEventAttachmentFactory;
    }

    /**
     * @throws \App\Services\Libraries\Exceptions\LibraryNotFoundException
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function make(CreateLibraryTicketEventResource $resource): Ticket
    {
        /** @var \App\Services\Libraries\Factories\Library $library */
        $library = $this->libraryRepository->find($resource->getLibraryId());

        if ($library === null) {
            throw new LibraryNotFoundException('Library not found');
        }

        $department = $this->departmentRepository->findByName('Graphics Department');

        $dueDate = (new Carbon())->addDays(7);

        $ticketCreator = $this->ticketTypeResolverFactory->make(new TicketTypeEnum(TicketTypeEnum::EVENT));

        $ticket = $ticketCreator->create(new CreateTicketResource([
            'priority' => TicketPrioritiesEnum::STANDARD,
            'client' => $resource->getClientUser()->getClient(),
            'createdBy' => $resource->getClientUser()->getUser(),
            'department' => $department,
            'description' => $resource->getDescription(),
            'dueDate' => $dueDate,
            'requestedBy' => $resource->getClientUser()->getUser(),
            'subject' => 'Library request',
            'attachment' => null,
            'type' => new TicketTypeEnum(TicketTypeEnum::LIBRARY),
        ]));

        $this->ticketEventAttachmentFactory->make(new CreateTicketEventAttachmentResource([
            'ticketEvent' => $ticket->getTicketEvent(),
            'file' => $library->getFile(),
        ]));

        return $ticket;
    }
}
