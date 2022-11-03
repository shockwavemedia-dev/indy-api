<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasSocialMediaRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

final class SocialMediaActivity extends AbstractModel
{
    use HasFactory, HasSocialMediaRelationship;

    protected $table = 'social_media_activities';

    protected $fillable = [
        'social_media_id',
        'old_value',
        'new_value',
        'created_at',
        'created_by',
    ];
}
