<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientScreen extends AbstractModel
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'screen_id',
    ];

    protected $table = 'client_screens';

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getScreen(): Screen
    {
        return $this->screen;
    }

    public function screen(): BelongsTo
    {
        return $this->belongsTo(Screen::class, 'screen_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
