<?php

declare(strict_types=1);

namespace App\Models\Tickets;

use App\Enum\TicketFileStatusEnum;
use App\Models\AbstractModel;
use App\Models\Client;
use App\Models\Emails\Interfaces\EmailInterface;
use App\Models\File;
use App\Models\TicketFileVersion;
use App\Models\User;
use App\Models\Users\AdminUser;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

final class ClientTicketFile extends AbstractModel implements EmailInterface
{
    use SoftDeletes, HasFactory;

    /**
     * @var string[]
     */
    protected $dates = [
        'approved_at',
        'created_at',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'file_id',
        'client_id',
        'ticket_id',
        'status',
        'description',
        'admin_user_id',
        'approved_by',
        'approved_at',
    ];

    protected $table = 'client_ticket_files';

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getApprovedAt(): ?DateTimeInterface
    {
        return $this->getAttribute('approved_at');
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getFileId(): int
    {
        return $this->getAttribute('file_id');
    }

    public function getClientId(): int
    {
        return $this->getAttribute('client_id');
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getTicketId(): int
    {
        return $this->getAttribute('ticket_id');
    }

    public function getStatus(): TicketFileStatusEnum
    {
        $status = $this->getAttribute('status');

        return new TicketFileStatusEnum($status);
    }

    public function getDescription(): ?string
    {
        return $this->getAttribute('description');
    }

    public function getAdminUser(): AdminUser
    {
        return $this->adminUser;
    }

    public function getAdminUserId(): int
    {
        return $this->getAttribute('admin_user_id');
    }

    public function getApprovedBy(): ?User
    {
        return $this->approvedBy;
    }

    public function getApprovedById(): ?int
    {
        return $this->getAttribute('approved_by');
    }

    public function isApproved(): bool
    {
        return $this->getApprovedBy() !== null;
    }

    public function setApprovedAt(DateTimeInterface $date): self
    {
        $this->setAttribute('approved_at', $date);

        return $this;
    }

    public function setStatus(TicketFileStatusEnum $status): self
    {
        $this->setAttribute('status', $status->getValue());

        return $this;
    }

    public function getApproveFile(): ?File
    {
        /** @var TicketFileVersion $fileVersion */
        $fileVersion = $this->fileVersions()->where('status', TicketFileStatusEnum::APPROVED)->first();

        return $fileVersion?->getFile();
    }

    public function getLatestFileVersion(): ?TicketFileVersion
    {
        /** @var TicketFileVersion $fileVersion */
        $fileVersion = $this->fileVersions()->latest()->first();

        return $fileVersion;
    }

    public function getFileVersions(): Collection
    {
        return $this->fileVersions;
    }

    public function fileVersions(): HasMany
    {
        return $this->hasMany(TicketFileVersion::class, 'ticket_file_id');
    }

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
