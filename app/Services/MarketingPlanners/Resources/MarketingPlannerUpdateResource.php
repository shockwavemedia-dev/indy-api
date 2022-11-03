<?php

declare(strict_types=1);

namespace App\Services\MarketingPlanners\Resources;

use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;
use DateTime;

final class MarketingPlannerUpdateResource extends DataTransferObject
{
    public ?string $eventName = null;

    public ?string $description = null;

    public ?array $todoList = null;

    public ?array $taskManagement = null;

    public ?Carbon $startDate = null;

    public ?Carbon $endDate = null;

    public ?bool $isRecurring = null;

    public User $updatedBy;

    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getTodoList(): ?array
    {
        return $this->todoList;
    }

    public function getTaskManagement(): ?array
    {
        return $this->taskManagement;
    }

    public function getStartDate(): ?Carbon
    {
        return $this->startDate;
    }

    public function getEndDate(): ?Carbon
    {
        return $this->endDate;
    }
    public function isRecurring(): ?bool
    {
        return $this->isRecurring;
    }

    public function getUpdatedBy(): User
    {
        return $this->updatedBy;
    }
}
