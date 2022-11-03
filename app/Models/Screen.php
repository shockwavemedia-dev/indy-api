<?php

namespace App\Models;

use App\Models\Traits\HasRelationshipWithUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Screen extends AbstractModel
{
    use HasFactory, HasRelationshipWithUser, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'logo_file_id',
        'created_by',
    ];

    protected $table = 'screens';

    public function getLogoFile(): ?File
    {
        return $this->logo;
    }

    public function logo(): BelongsTo
    {
        return $this->belongsTo(File::class, 'logo_file_id');
    }

    public function clientScreens(): HasMany
    {
        return $this->hasMany(ClientScreen::class, 'screen_id');
    }
}
