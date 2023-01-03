<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\NotificationUserStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class NotificationUser extends AbstractModel
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'notification_id',
        'user_id',
        'title',
        'status',
    ];

    /**
     * @var string
     */
    protected $table = 'notification_users';

    public $timestamps = false;

    public function getStatus(): NotificationUserStatusEnum
    {
        $status = $this->getAttribute('status');

        return new NotificationUserStatusEnum($status);
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
