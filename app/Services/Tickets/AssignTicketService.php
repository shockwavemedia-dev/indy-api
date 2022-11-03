<?php

declare(strict_types=1);

namespace App\Services\Tickets;

use App\Jobs\Tickets\TicketAssigneeLinkJob;
use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketAssignee;
use App\Models\Users\AdminUser;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Services\TicketAssigneeLinks\Interfaces\TicketAssigneeLinkResolverInterface;
use App\Services\Tickets\Interfaces\AssignTicketServiceInterface;
use Illuminate\Support\Arr;

final class AssignTicketService implements AssignTicketServiceInterface
{
    private TicketAssigneeRepositoryInterface $assigneeRepository;

    public function __construct(
        TicketAssigneeLinkResolverInterface $ticketAssigneeLinkResolver,
        TicketAssigneeRepositoryInterface $assigneeRepository
    ) {
        $this->assigneeRepository = $assigneeRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function assign(
        Ticket $ticket,
        AdminUser $adminUser,
        AdminUser $createdBy,
        ?array $links = null
    ): TicketAssignee {
        $mainTicketAssignee = $this->assigneeRepository->assignTicket($adminUser, $createdBy, $ticket);

        if ($links === null) {
            return $mainTicketAssignee;
        }

        foreach ($links as $link) {
            TicketAssigneeLinkJob::dispatch(
                $createdBy->getUser(),
                $mainTicketAssignee,
                Arr::get($link, 'ticket_assignee_id'),
                Arr::get($link, 'issue'),
            );
        }

        return $mainTicketAssignee;
    }
}
