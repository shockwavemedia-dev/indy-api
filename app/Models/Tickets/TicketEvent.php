<?php

declare(strict_types=1);

namespace App\Models\Tickets;

use App\Models\AbstractModel;
use App\Models\Emails\Interfaces\EmailInterface;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class TicketEvent extends AbstractModel implements EmailInterface
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'ticket_id',
        'duedate',
    ];

    protected $table = 'ticket_events';

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getAttachments(): Collection
    {
        return $this->attachmentFiles;
    }

    public function getTicketId(): int
    {
        return $this->getAttribute('ticket_id');
    }

    public function getDueDate(): DateTimeInterface
    {
        return $this->getAttribute('duedate');
    }

    public function getTicket(): Ticket
    {
        /** @var Ticket $ticket */
        $ticket = $this->ticket;

        return $ticket;
    }

    public function setDueDate(DateTimeInterface $dueDate): self
    {
        $this->setAttribute('duedate', $dueDate);

        return $this;
    }

    public function attachmentFiles(): HasMany
    {
        return $this->hasMany(TicketEventAttachment::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
