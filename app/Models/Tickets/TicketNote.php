<?php

namespace App\Models\Tickets;

use App\Models\AbstractModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class TicketNote extends AbstractModel
{
    use SoftDeletes, HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'note',
        'ticket_id',
        'created_by',
        'updated_by',
    ];

    /**
     * @var string
     */
    protected $table = 'ticket_notes';

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


    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
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
