<?php

namespace App\Models;

use App\Models\Emails\Interfaces\EmailInterface;
use App\Models\Tickets\Ticket;
use App\Models\Traits\HasRelationshipWithUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TicketChat extends AbstractModel implements EmailInterface
{
    use HasFactory, HasRelationshipWithUser;

    protected $fillable = [
        'ticket_id',
        'message',
        'created_by',
    ];

    protected $table = 'ticket_chats';

    public function getMessage(): string
    {
        return $this->getAttribute('message');
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
