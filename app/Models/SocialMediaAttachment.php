<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasSocialMediaRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableInterface;

final class SocialMediaAttachment extends AbstractModel implements AuditableInterface
{
    use HasFactory, HasSocialMediaRelationship, Auditable;

    protected $table = 'social_media_attachments';

    protected $fillable = [
        'social_media_id',
        'file_id',
        'created_at',
    ];

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
