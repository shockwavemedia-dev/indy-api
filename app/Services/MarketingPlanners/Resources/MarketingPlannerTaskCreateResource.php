<?php

declare(strict_types=1);

namespace App\Services\MarketingPlanners\Resources;

use App\Models\MarketingPlanner;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

final class MarketingPlannerTaskCreateResource extends DataTransferObject
{
    public MarketingPlanner $marketingPlanner;

    public string $name;

    public array $assignees;

    public string $status;

    public Carbon $deadline;

    public ?bool $notify = false;

    public function getNotify(): bool
    {
        return filter_var($this->notify, FILTER_VALIDATE_BOOLEAN);
    }

    public function getMarketingPlanner(): MarketingPlanner
    {
        return $this->marketingPlanner;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAssignees(): array
    {
        return $this->assignees;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDeadline(): Carbon
    {
        return $this->deadline;
    }
}
