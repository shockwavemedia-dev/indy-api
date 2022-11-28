<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketFileVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_file_id',
        'file_id',
        'status',
        'version',
    ];

    protected $table = 'ticket_file_versions';
}
