<?php

declare(strict_types=1);

namespace App\Models\Tickets;

use App\Enum\TicketEmailStatusEnum;
use App\Models\AbstractModel;
use App\Models\Client;
use App\Models\Emails\Interfaces\EmailInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

final class TicketEmail extends AbstractModel implements EmailInterface
{
    use Notifiable, HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'client_id',
        'cc',
        'is_read',
        'message',
        'sender_by',
        'sender_type',
        'status',
        'ticket_id',
        'title',
        'updated_by',
    ];

    protected $table = 'ticket_emails';

    public function IsRead(): bool
    {
        $isRead = $this->getAttribute('is_read');

        if ($isRead === '' || $isRead === null) {
            $isRead = 0;
        }

        return $isRead > 0;
    }

    public function getCc(): ?string
    {
        return $this->getAttribute('cc') ?? null;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getClientId(): int
    {
        return $this->getAttribute('client_id');
    }

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getMessage(): string
    {
        return $this->getAttribute('message');
    }

    public function getSenderById(): int
    {
        return $this->getAttribute('sender_by');
    }

    public function getSenderType(): string
    {
        return $this->getAttribute('sender_type');
    }

    public function getSenderBy(): User
    {
        return $this->senderBy;
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getTicketId(): int
    {
        return $this->getAttribute('ticket_id');
    }

    public function getTitle(): string
    {
        return $this->getAttribute('title');
    }

    public function getUpdatedById(): int
    {
        return $this->getAttribute('updated_by');
    }

    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    public function setSenderType(string $senderType): self
    {
        $this->setAttribute('sender_type', $senderType);

        return $this;
    }

    public function getStatus(): TicketEmailStatusEnum
    {
        $status = $this->getAttribute('status');

        return new TicketEmailStatusEnum($status);
    }

    public function markAsRead(bool $markAsRead): self
    {
        $this->setAttribute('is_read', $markAsRead);

        return $this;
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function setCc(?string $cc = null): self
    {
        $this->setAttribute('cc', $cc);

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->setAttribute('message', $message);

        return $this;
    }

    public function setSenderBy(User $user): self
    {
        $this->senderBy()->associate($user);

        return $this;
    }

    public function setStatus(TicketEmailStatusEnum $status): self
    {
        $this->setAttribute('status', $status->getValue());

        return $this;
    }

    public function setUpdatedBy(User $user): self
    {
        $this->setAttribute('updated_by', $user->getId());

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->setAttribute('title', $title);

        return $this;
    }

    public function senderBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_by');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
