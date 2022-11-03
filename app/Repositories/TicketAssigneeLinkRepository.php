<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enum\TicketAssigneeLinkIssueEnum;
use App\Models\Tickets\TicketAssignee;
use App\Models\Tickets\TicketAssigneeLink;
use App\Repositories\Interfaces\TicketAssigneeLinkRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final class TicketAssigneeLinkRepository extends BaseRepository implements TicketAssigneeLinkRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new TicketAssigneeLink());
    }

    public function findByTwoTicketAssignee(
        TicketAssignee $mainAssignee,
        TicketAssignee $linkAssignee,
        TicketAssigneeLinkIssueEnum $linkIssueEnum
    ): ?Collection {
        return $this->model
                ->where(function ($query) use ($mainAssignee, $linkAssignee, $linkIssueEnum) {
                    $query->where('main_assignee_id', '=', $mainAssignee->getId());
                    $query->where('link_assignee_id', '=', $linkAssignee->getId());
                    $query->where('link_issue', $linkIssueEnum->getValue());
                })->orWhere(function ($query) use ($mainAssignee, $linkAssignee, $linkIssueEnum) {
                    $query->where('link_assignee_id', '=', $mainAssignee->getId());
                    $query->where('main_assignee_id', '=', $linkAssignee->getId());
                    $query->where('link_issue', $linkIssueEnum->getOppositeLinkedIssue()->getValue());
                })
                ->get() ?? null;
    }
}
