<?php

declare(strict_types=1);

namespace App\Services\TicketAssigneeLinks;

use App\Repositories\Interfaces\TicketAssigneeLinkRepositoryInterface;
use App\Services\TicketAssigneeLinks\Interfaces\TicketAssigneeLinkFactoryInterface;
use App\Services\TicketAssigneeLinks\Interfaces\TicketAssigneeLinkResolverInterface;
use App\Services\TicketAssigneeLinks\Resources\CreateTicketAssigneeLinkResource;
use Illuminate\Database\Eloquent\Collection;

final class TicketAssigneeLinkResolver implements TicketAssigneeLinkResolverInterface
{
    private TicketAssigneeLinkFactoryInterface $assigneeLinkFactory;

    private TicketAssigneeLinkRepositoryInterface $assigneeLinkRepository;

    public function __construct(
        TicketAssigneeLinkFactoryInterface $assigneeLinkFactory,
        TicketAssigneeLinkRepositoryInterface $ticketAssigneeLinkRepository
    ) {
        $this->assigneeLinkFactory = $assigneeLinkFactory;
        $this->assigneeLinkRepository = $ticketAssigneeLinkRepository;
    }

    /**
     * @throws \App\Services\TicketAssigneeLinks\UnknownProperties
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function resolve(CreateTicketAssigneeLinkResource $resource): void
    {
        /** @var \App\Services\TicketAssigneeLinks\TicketAssigneeLink $exist */
        $links = $this->assigneeLinkRepository->findByTwoTicketAssignee(
            $resource->getMainAssignee(),
            $resource->getLinkAssignee(),
            $resource->getLinkIssue()
        );

        $this->assigneeLinkFactory->make($resource);

        $this->assigneeLinkFactory->make(new CreateTicketAssigneeLinkResource([
            'createdBy' => $resource->getCreatedBy(),
            'linkAssignee' => $resource->getMainAssignee(),
            'mainAssignee' => $resource->getLinkAssignee(),
            'linkIssue' => $resource->getLinkIssue()->getOppositeLinkedIssue()
        ]));
    }
}
