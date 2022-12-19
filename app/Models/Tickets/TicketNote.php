<?php

namespace App\Models\Tickets;

use App\Models\AbstractModel;
use App\Models\Emails\Interfaces\EmailInterface;
use App\Models\NoteAttachment;
use App\Models\TicketFileVersion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class TicketNote extends AbstractModel implements EmailInterface
{
    use SoftDeletes, HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'note',
        'ticket_id',
        'created_by',
        'ticket_file_version_id',
        'updated_by',
    ];

    /**
     * @var string
     */
    protected $table = 'ticket_notes';

    public function getAttachments(): Collection
    {
        return $this->attachments;
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getTicketId(): int
    {
        return $this->getAttribute('ticket_id');
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getUpdatedUser(): User
    {
        return $this->updatedUser;
    }

    public function getNote(): ?string
    {
        return $this->getAttribute('note');
    }

    public function getCreatedById(): int
    {
        return $this->getAttribute('created_by');
    }

    public function getUpdatedById(): int
    {
        return $this->getAttribute('updated_by');
    }

    public function getDeletedAt(): ?Carbon
    {
        return $this->getAttribute('deleted_at');
    }

    public function setNote(string $note): self
    {
        return $this->setAttribute('note', $note);
    }

    public function setCreatedBy(User $user): self
    {
        $this->createdBy()->associate($user);

        return $this;
    }

    public function setUpdatedBy(User $user): self
    {
        $this->updatedUser()->associate($user);

        return $this;
    }

    public function getTicketFileVersion(): ?TicketFileVersion
    {
        return $this->ticketFileVersion;
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(NoteAttachment::class, 'ticket_note_id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function ticketFileVersion(): BelongsTo
    {
        return $this->belongsTo(TicketFileVersion::class, 'ticket_file_version_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
