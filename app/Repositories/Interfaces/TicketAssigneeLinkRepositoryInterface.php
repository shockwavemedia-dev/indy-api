<?php

namespace App\Repositories\Interfaces;

use App\Enum\TicketAssigneeLinkIssueEnum;
use App\Models\Tickets\TicketAssignee;
use App\Models\Tickets\TicketAssigneeLink;
use Illuminate\Database\Eloquent\Collection;

interface TicketAssigneeLinkRepositoryInterface
{
    public function findByTwoTicketAssignee(
        TicketAssignee $mainAssignee,
        TicketAssignee $linkAssignee,
        TicketAssigneeLinkIssueEnum $linkIssueEnum
    ): ?Collection;
}
