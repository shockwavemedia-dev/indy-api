<?php

declare(strict_types=1);

namespace App\Models\Tickets;

use App\Enum\TicketAssigneeStatusEnum;
use App\Models\AbstractModel;
use App\Models\Department;
use App\Models\Emails\Interfaces\EmailInterface;
use App\Models\Users\AdminUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class TicketAssignee extends AbstractModel implements EmailInterface
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'created_by',
        'ticket_id',
        'admin_user_id',
        'department_id',
        'status',
        'updated_by',
    ];

    protected $table = 'ticket_assignees';

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getTicketId(): int
    {
        return $this->getAttribute('ticket_id');
    }

    public function getAdminUserId(): int
    {
        return $this->getAttribute('admin_user_id');
    }

    public function getCreatedBy(): AdminUser
    {
        return $this->createdBy;
    }

    public function getCreatedById(): int
    {
        return $this->getAttribute('created_by');
    }

    public function getDepartmentId(): int
    {
        return $this->getAttribute('department_id');
    }

    public function getDueDate(): DateTimeInterface
    {
        return $this->getAttribute('duedate');
    }

    public function getAdminUser(): AdminUser
    {
        return $this->adminUser;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function getStatus(): TicketAssigneeStatusEnum
    {
        $status = $this->getAttribute('status');

        return new TicketAssigneeStatusEnum($status);
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function getUpdatedBy(): ?AdminUser
    {
        return $this->updatedBy;
    }

    public function getAssigneeLinks(): Collection
    {
        return $this->ticketLinks;
    }

    public function setStatus(?TicketAssigneeStatusEnum $statusEnum = null): self
    {
        if ($statusEnum === null) {
            return $this;
        }

        $this->setAttribute('status', $statusEnum->getValue());

        return $this;
    }

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'created_by');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function ticketLinks(): HasMany
    {
        return $this->hasMany(TicketAssigneeLink::class, 'main_assignee_id');
    }

    public function updatedBy(): ?BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'updated_by');
    }
}
