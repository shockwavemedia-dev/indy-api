<?php

declare(strict_types=1);

namespace App\Services\TicketAssigneeLinks;

use App\Models\Tickets\TicketAssigneeLink;
use App\Repositories\Interfaces\TicketAssigneeLinkRepositoryInterface;
use App\Services\TicketAssigneeLinks\Interfaces\TicketAssigneeLinkFactoryInterface;
use App\Services\TicketAssigneeLinks\Resources\CreateTicketAssigneeLinkResource;

final class TicketAssigneeLinkFactory implements TicketAssigneeLinkFactoryInterface
{
    private TicketAssigneeLinkRepositoryInterface $ticketAssigneeLinkRepository;

    public function __construct(TicketAssigneeLinkRepositoryInterface $ticketAssigneeLinkRepository) {
        $this->ticketAssigneeLinkRepository = $ticketAssigneeLinkRepository;
    }

    public function make(CreateTicketAssigneeLinkResource $resource): TicketAssigneeLink
    {
        /** @var TicketAssigneeLink $ticketAssigneeLink */
        $ticketAssigneeLink = $this->ticketAssigneeLinkRepository->create([
            'main_assignee_id' => $resource->getMainAssignee()->getId(),
            'link_issue' => $resource->getLinkIssue()->getValue(),
            'link_assignee_id' => $resource->getLinkAssignee()->getId(),
            'created_by' => $resource->getCreatedBy()->getId(),
        ]);

        return $ticketAssigneeLink;
    }
}
