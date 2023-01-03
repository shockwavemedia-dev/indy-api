<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketingPlannerTaskAssignee extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
    ];

    protected $table = 'marketing_planner_task_assignees';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function marketingPlannerTask(): BelongsTo
    {
        return $this->belongsTo(MarketingPlannerTask::class);
    }
}
