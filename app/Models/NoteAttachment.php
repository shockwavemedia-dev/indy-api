<?php

namespace App\Models;

use App\Models\Tickets\TicketNote;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class NoteAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_id',
        'ticket_note_id',
        'created_by',
    ];

    protected $table = 'note_attachments';

    public function getFile()
    {
        return $this->file;
    }

    public function getTicketNote(): TicketNote
    {
        return $this->ticketNote;
    }

    public function ticketNote(): BelongsTo
    {
        return $this->belongsTo(TicketNote::class, 'ticket_note_id');
    }

    protected function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
