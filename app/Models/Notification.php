<?php

namespace App\Models;

use App\Enum\NotificationStatusEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Notification extends AbstractModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'description',
        'link',
        'morphable_id',
        'morphable_type',
        'status',
        'title',
        'user_id',
    ];

    public function getLink(): ?string
    {
        return $this->getAttribute('link');
    }

    public function getNotificationUsers(): Collection
    {
        return $this->notificationUsers;
    }

    public function getStatus(): NotificationStatusEnum
    {
        $status = $this->getAttribute('status');

        return new NotificationStatusEnum($status);
    }

    public function getTitle(): string
    {
        return $this->getAttribute('title');
    }

    /**
     * @var string
     */
    protected $table = 'notifications';

    public function getType(): mixed
    {
        return $this->type;
    }

    public function notificationUsers(): HasMany
    {
        return $this->hasMany(NotificationUser::class, 'notification_id');
    }

    public function type(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'morphable_type', 'morphable_id');
    }
}
