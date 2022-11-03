<?php

declare(strict_types=1);

namespace App\Jobs\Tickets;

use App\Enum\TicketAssigneeLinkIssueEnum;
use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\Tickets\TicketAssignee;
use App\Models\User;
use App\Repositories\Interfaces\TicketAssigneeRepositoryInterface;
use App\Services\TicketAssigneeLinks\Interfaces\TicketAssigneeLinkResolverInterface;
use App\Services\TicketAssigneeLinks\Resources\CreateTicketAssigneeLinkResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sentry\Severity;
use Throwable;

final class TicketAssigneeLinkJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $linkIssue;

    private int $ticketAssigneeId;

    private TicketAssignee $mainTicketAssignee;

    private User $createdBy;

    public function __construct(
        User $createdBy,
        TicketAssignee $mainTicketAssignee,
        int $ticketAssigneeId,
        string $linkIssue
    ) {
        $this->createdBy = $createdBy->withoutRelations();
        $this->mainTicketAssignee = $mainTicketAssignee->withoutRelations();
        $this->ticketAssigneeId = $ticketAssigneeId;
        $this->linkIssue = $linkIssue;
    }

    public function handle(
        ErrorLogInterface $errorLog,
        TicketAssigneeRepositoryInterface $ticketAssigneeRepository,
        TicketAssigneeLinkResolverInterface $ticketAssigneeLinkResolver

    ): void {
        try {
            $ticketAssignee = $ticketAssigneeRepository->find($this->ticketAssigneeId);

            if ($ticketAssignee === null) {
                $errorLog->log('Invalid ticket assignee id', Severity::error());

                return;
            }

            $ticketAssigneeLinkResolver->resolve(new CreateTicketAssigneeLinkResource([
                'mainAssignee' => $this->mainTicketAssignee,
                'linkAssignee' => $ticketAssignee,
                'linkIssue' => new TicketAssigneeLinkIssueEnum($this->linkIssue),
                'createdBy' => $this->createdBy,
            ]));
        } catch (Throwable $throwable) {
            $errorLog->reportError($throwable);
        }
    }
}
