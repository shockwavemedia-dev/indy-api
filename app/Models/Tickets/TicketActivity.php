<?php

namespace App\Models\Tickets;

use App\Models\AbstractModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TicketActivity extends AbstractModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'activity',
        'ticket_id',
        'user_id',
    ];

    /**
     * @var string
     */
    protected $table = 'ticket_activities';

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getTicketId(): int
    {
        return $this->getAttribute('ticket_id');
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getActivity(): string
    {
        return $this->getAttribute('activity');
    }

    public function getUserId(): int
    {
        return $this->getAttribute('user_id');
    }

    public function setTicket(Ticket $ticket): self
    {
        $this->ticket()->associate($ticket);

        return $this;
    }

    public function setCreatedBy(User $user): self
    {
        $this->user()->associate($user);

        return $this;
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
