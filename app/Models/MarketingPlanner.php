<?php

namespace App\Models;

use App\Models\Traits\HasRelationshipWithUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingPlanner extends AbstractModel
{
    use HasFactory,HasRelationshipWithUser,SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'client_id',
        'event_name',
        'description',
        'start_date',
        'end_date',
        'is_recurring',
        'created_by',
        'updated_by',
    ];

    /**
     * @var string
     */
    protected $table = 'marketing_planners';

    public function isRecurring(): bool
    {
        return $this->getAttribute('is_recurring');
    }

    public function getAttachments(): Collection
    {
        return $this->attachments ?? new Collection();
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getDescription(): ?string
    {
        return $this->getAttribute('description');
    }

    public function getEventName(): string
    {
        return $this->getAttribute('event_name');
    }

    public function getTaskManagement(): ?array
    {
        return $this->getAttribute('task_management');
    }

    public function getTodoList(): ?array
    {
        return $this->getAttribute('todo_list');
    }

    public function getEndDate(): Carbon
    {
        return new Carbon($this->getAttribute('end_date'));
    }

    public function getEndDateAsString(): string
    {
        return (new Carbon($this->getAttribute('end_date')))->toDateTimeString();
    }

    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function getStartDate(): Carbon
    {
        return new Carbon($this->getAttribute('start_date'));
    }

    public function getStartDateAsString(): string
    {
        return (new Carbon($this->getAttribute('start_date')))->toDateTimeString();
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(MarketingPlannerAttachment::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(MarketingPlannerTask::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
