<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketingPlannerTask extends AbstractModel
{
    use HasFactory;

    protected $table = 'marketing_planner_tasks';

    protected $casts = [
        'notify' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'deadline',
        'status',
        'marketing_planner_id',
        'notify',
    ];

    public function getAssignees(): Collection
    {
        return $this->assignees;
    }

    public function getMarketingPlanner(): MarketingPlanner
    {
        return $this->marketingPlanner;
    }

    public function marketingPlanner(): BelongsTo
    {
        return $this->belongsTo(MarketingPlanner::class, 'marketing_planner_id');
    }

    public function assignees(): HasMany
    {
        return $this->hasMany(MarketingPlannerTaskAssignee::class, 'task_id');
    }
}
