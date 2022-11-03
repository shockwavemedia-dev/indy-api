<?php

declare(strict_types=1);

namespace App\Services\TicketAssigneeLinks\Resources;

use App\Enum\TicketAssigneeLinkIssueEnum;
use App\Models\Tickets\TicketAssignee;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateTicketAssigneeLinkResource extends DataTransferObject
{
    public User $createdBy;

    public TicketAssignee $linkAssignee;

    public TicketAssigneeLinkIssueEnum $linkIssue;

    public TicketAssignee $mainAssignee;

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getLinkAssignee(): TicketAssignee
    {
        return $this->linkAssignee;
    }

    public function getLinkIssue(): TicketAssigneeLinkIssueEnum
    {
        return $this->linkIssue;
    }

    public function getMainAssignee(): TicketAssignee
    {
        return $this->mainAssignee;
    }

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function setLinkAssignee(TicketAssignee $linkAssignee): self
    {
        $this->linkAssignee = $linkAssignee;

        return $this;
    }

    public function setLinkIssue(TicketAssigneeLinkIssueEnum $linkIssue): self
    {
        $this->linkIssue = $linkIssue;

        return $this;
    }

    public function setMainAssignee(TicketAssignee $mainAssignee): self
    {
        $this->mainAssignee = $mainAssignee;

        return $this;
    }
}
