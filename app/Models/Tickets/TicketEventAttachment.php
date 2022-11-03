<?php

namespace App\Models\Tickets;

use App\Models\AbstractModel;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TicketEventAttachment extends AbstractModel
{
    use HasFactory;

    protected $table = 'ticket_event_attachments';

    public $timestamps = false;
    /**
     * @var string[]
     */
    protected $fillable = [
        'ticket_event_id',
        'file_id',
    ];

    public function getFile(): File
    {
        return $this->file;
    }

    public function getFileId(): int
    {
        return $this->getAttribute('file_id');
    }

    public function getTicketEvent(): TicketEvent
    {
        return $this->ticketEvent;
    }

    public function getTicketId(): int
    {
        return $this->getAttribute('ticket_event_id');
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function ticketEvent(): BelongsTo
    {
        return $this->belongsTo(TicketEvent::class, 'ticket_event_id');
    }
}
