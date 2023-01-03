<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\SupportRequestStatusEnum;
use App\Models\Emails\Interfaces\EmailInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class SupportRequest extends AbstractModel implements EmailInterface
{
    use HasFactory;

    protected $fillable = [
        'assigned_to',
        'client_id',
        'created_by',
        'department_id',
        'message',
        'status',
    ];

    /**
     * @var string
     */
    protected $table = 'support_requests';

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function getMessage(): string
    {
        return $this->getAttribute('message');
    }

    public function getStatus(): SupportRequestStatusEnum
    {
        $status = $this->getAttribute('status');

        return new SupportRequestStatusEnum($status);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
