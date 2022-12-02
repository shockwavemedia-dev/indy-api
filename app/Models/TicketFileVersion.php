<?php

namespace App\Models;

use App\Models\Tickets\ClientTicketFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketFileVersion extends AbstractModel
{
    use HasFactory;

    protected $fillable = [
        'ticket_file_id',
        'file_id',
        'status',
        'version',
    ];

    protected $table = 'ticket_file_versions';

    public function getVersion(): int
    {
        return (int) $this->getAttribute('version');
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function getTicketFile(): ClientTicketFile
    {
        return $this->ticketFile;
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function ticketFile(): BelongsTo
    {
        return $this->belongsTo(ClientTicketFile::class, 'ticket_file_id');
    }
}
