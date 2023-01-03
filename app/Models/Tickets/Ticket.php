<?php

declare(strict_types=1);

namespace App\Models\Tickets;

use App\Enum\TicketPrioritiesEnum;
use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
use App\Enum\UserTypeEnum;
use App\Models\AbstractModel;
use App\Models\Client;
use App\Models\Department;
use App\Models\Emails\Interfaces\EmailInterface;
use App\Models\TicketChat;
use App\Models\User;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Ticket extends AbstractModel implements EmailInterface
{
    use SoftDeletes, HasFactory;

    public $dates = [
        'duedate',
    ];

    protected $casts = [
        'user_notes' => 'array',
        'is_approval_required' => 'boolean',
    ];

    /**
     * @var string[]
     */
    public $fillable = [
        'email_html',
        'priority',
        'client_id',
        'created_by',
        'updated_by',
        'created_by_user_type',
        'department_id',
        'deleted_by',
        'duedate',
        'requested_by',
        'ticket_code',
        'subject',
        'description',
        'type',
        'status',
        'user_notes',
        'is_approval_required',
    ];

    public $table = 'tickets';

    public function activities(): HasMany
    {
        return $this->hasMany(TicketActivity::class);
    }

    public function getChats(): Collection
    {
        return $this->chats()->orderBy('id', 'desc')->get();
    }

    public function getUserNotes(): array
    {
        $userNotes = $this->getAttribute('user_notes');

        if (is_array($userNotes) === true) {
            return $userNotes;
        }

        if (is_string($userNotes) === true) {
            return (array) json_decode($userNotes);
        }

        return [];
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getClient(): ?Client
    {
        /** @var \App\Models\Client $client */
        $client = $this->client;

        return $client;
    }

    public function getClientId(): ?int
    {
        return $this->getAttribute('client_id');
    }

    public function getCreatedById(): int
    {
        return $this->getAttribute('created_by');
    }

    public function getCreatedByUserType(): string
    {
        return $this->getAttribute('created_by_user_type');
    }

    public function getDepartmentId(): int
    {
        return $this->getAttribute('department_id');
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getUserType(): UserTypeEnum
    {
        /** @var \App\Models\User $user */
        $userType = $this->getAttribute('created_by_user_type');

        return new UserTypeEnum($userType);
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function getDescription(): ?string
    {
        return $this->getAttribute('description');
    }

    public function getDueDate(): ?DateTimeInterface
    {
        return $this->getAttribute('duedate');
    }

    public function getClientTicketFiles(): Collection
    {
        return $this->clientTicketFiles;
    }

    public function getPriority(): string
    {
        return $this->getAttribute('priority');
    }

    public function getRequestedById(): int
    {
        return (int) $this->getAttribute('requested_by');
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updatedBy;
    }

    public function getUpdatedById(): int
    {
        return (int) $this->getAttribute('updated_by');
    }

    public function getRequestedBy(): User
    {
        return $this->requestedBy;
    }

    public function getSubject(): string
    {
        return $this->attributes('subject');
    }

    public function getStatus(): TicketStatusEnum
    {
        $status = $this->attributes('status');

        return new TicketStatusEnum($status);
    }

    public function getTicketAssignees(): Collection
    {
        return $this->assignees;
    }

    public function getTicketCode(): string
    {
        return $this->attributes('ticket_code');
    }

    public function getTicketEmails(): Collection
    {
        return $this->ticketEmails;
    }

    public function isOverdue(): bool
    {
        $dateToday = new Carbon();

        $createdAt = $this->getCreatedAt();

        $hours = $createdAt->diffInHours($dateToday);

        if ($this->getPriority() === TicketPrioritiesEnum::RELAXED && $hours > 120) {
            return true;
        }

        if ($this->getPriority() === TicketPrioritiesEnum::STANDARD && $hours > 48) {
            return true;
        }

        if ($this->getPriority() === TicketPrioritiesEnum::URGENT && $hours > 24) {
            return true;
        }

        return false;
    }

    public function getTicketEvent(): ?TicketEvent
    {
        return $this->ticketEvent ?? null;
    }

    public function getTicketServices(): Collection
    {
        return $this->ticketServices;
    }

    public function getType(): TicketTypeEnum
    {
        $type = $this->attributes('type');

        return new TicketTypeEnum($type);
    }

    public function isApprovalRequired(): bool
    {
        return $this->getAttribute('is_approval_required');
    }

    public function setDescription(string $description): self
    {
        return $this->setAttribute('description', $description);
    }

    public function setDueDate(?DateTimeInterface $dueDate = null): self
    {
        $this->setAttribute('duedate', $dueDate);

        return $this;
    }

    public function setPriority(TicketPrioritiesEnum $priorityEnum): self
    {
        $this->setAttribute('priority', $priorityEnum->getValue());

        return $this;
    }

    public function setSubject(string $subject): self
    {
        return $this->setAttribute('subject', $subject);
    }

    public function setStatus(TicketStatusEnum $status): self
    {
        $this->setAttribute('status', $status->getValue());

        return $this;
    }

    public function setType(TicketTypeEnum $status): self
    {
        $this->setAttribute('type', $status->getValue());

        return $this;
    }

    public function setUpdatedBy(?User $user = null): self
    {
        $this->setAttribute('updated_by', $user?->getId());

        return $this;
    }

    public function setIsApprovalRequired(bool $approvalRequired): self
    {
        $this->setAttribute('is_approval_required', $approvalRequired);

        return $this;
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function assignees(): HasMany
    {
        return $this->hasMany(TicketAssignee::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(TicketChat::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function clientTicketFiles(): HasMany
    {
        return $this->hasMany(ClientTicketFile::class);
    }

    public function ticketServices(): HasMany
    {
        return $this->hasMany(TicketService::class);
    }

    public function ticketEvent(): ?HasOne
    {
        return $this->hasOne(TicketEvent::class);
    }

    public function ticketEmails(): HasMany
    {
        return $this->hasMany(TicketEmail::class);
    }
}
