<?php

namespace App\Models\Tickets;

use App\Enum\TicketAssigneeLinkIssueEnum;
use App\Models\AbstractModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TicketAssigneeLink extends AbstractModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'main_assignee_id',
        'link_issue',
        'link_assignee_id',
        'created_by',
        'updated_by',
    ];

    /**
     * @var string
     */
    protected $table = 'ticket_assignee_links';

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

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
        $link = $this->getAttribute('link_issue');

        return new TicketAssigneeLinkIssueEnum($link);
    }

    public function getMainAssignee(): TicketAssignee
    {
        return $this->mainAssignee;
    }

    public function getUpdatedBy(): User
    {
        return $this->updatedBy;
    }

    public function linkAssignee(): BelongsTo
    {
        return $this->belongsTo(TicketAssignee::class, 'link_assignee_id');
    }

    public function mainAssignee(): BelongsTo
    {
        return $this->belongsTo(TicketAssignee::class, 'main_assignee_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
