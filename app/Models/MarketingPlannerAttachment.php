<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketingPlannerAttachment extends AbstractModel
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'file_id',
        'marketing_planner_id',
    ];

    /**
     * @var string
     */
    protected $table = 'marketing_planner_attachments';

    public function getFile(): File
    {
        return $this->file;
    }

    public function getMarketingPlanner(): MarketingPlanner
    {
        return $this->marketingPlanner;
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function marketingPlanner(): BelongsTo
    {
        return $this->belongsTo(MarketingPlanner::class, 'marketing_planner_id');
    }
}
