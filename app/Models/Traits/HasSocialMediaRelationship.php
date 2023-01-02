<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasSocialMediaRelationship
{
    public function getSocialMedia(): SocialMedia
    {
        return $this->socialMedia;
    }

    public function socialMedia(): BelongsTo
    {
        return $this->belongsTo(SocialMedia::class);
    }
}
