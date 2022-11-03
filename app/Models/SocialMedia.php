<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasRelationshipWithUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableInterface;

final class SocialMedia extends AbstractModel implements AuditableInterface
{
    use HasFactory, SoftDeletes, HasRelationshipWithUser, Auditable;

    protected $casts = [
        'channels' => 'array',
        'post_date' => 'datetime',
    ];

    protected $fillable = [
        'campaign_type',
        'post',
        'copy',
        'status',
        'client_id',
        'ticket_id',
        'channels',
        'notes',
        'post_date',
        'created_at',
        'created_by',
        'updated_by',
    ];

    public function getAttachments(): ?Collection
    {
        return $this->attachments;
    }

    public function getCampaignType(): ?string
    {
        return $this->getAttribute('campaign_type');
    }

    public function getChannels(): ?array
    {
        return $this->getAttribute('channels');
    }

    public function getComments(): ?Collection
    {
        return $this->getAttribute('comments');
    }

    public function getNotes(): ?string
    {
        return $this->getAttribute('notes');
    }

    public function getPost(): string
    {
        return $this->getAttribute('post');
    }

    public function getCopy(): ?string
    {
        return $this->getAttribute('copy');
    }

    public function getStatus(): string
    {
        return $this->getAttribute('status');
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    protected $table = 'social_media';


    public function activities(): HasMany
    {
        return $this->hasMany(SocialMediaActivity::class, 'social_media_id');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(SocialMediaAttachment::class, 'social_media_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(SocialMediaComment::class, 'social_media_id');
    }

    public function getPostDate(): ?Carbon
    {
        return $this->getAttribute('post_date');
    }
}
