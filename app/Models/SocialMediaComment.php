<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Emails\Interfaces\EmailInterface;
use App\Models\Traits\HasRelationshipWithUser;
use App\Models\Traits\HasSocialMediaRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

final class SocialMediaComment extends AbstractModel implements EmailInterface
{
    use HasFactory, SoftDeletes, HasSocialMediaRelationship, HasRelationshipWithUser;

    protected $table = 'social_media_comments';

    protected $fillable = [
        'social_media_id',
        'comment',
        'created_at',
        'updated_by',
        'created_by',
    ];

    public function getComment(): string
    {
        return $this->getAttribute('comment');
    }
}
