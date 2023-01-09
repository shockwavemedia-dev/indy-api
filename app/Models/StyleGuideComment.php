<?php

namespace App\Models;

use App\Models\Tickets\Ticket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class StyleGuideComment extends AbstractModel
{
    use HasFactory;

    protected $table = 'style_guide_comments';

    protected $fillable = [
        'ticket_id',
        'message',
        'user_id',
    ];

    public function getMessage(): string
    {
        return $this->getAttribute('message');
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getUser(): User
    {
        return $this->user;
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
