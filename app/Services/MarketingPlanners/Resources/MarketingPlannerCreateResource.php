<?php

declare(strict_types=1);

namespace App\Services\MarketingPlanners\Resources;

use App\Models\Client;
use App\Models\User;
use DateTime;
use Spatie\DataTransferObject\DataTransferObject;

final class MarketingPlannerCreateResource extends DataTransferObject
{
    public Client $client;

    public string $eventName;

    public ?string $description = null;

    public ?array $todoList = null;

    public ?array $taskManagement = null;

    public DateTime $startDate;

    public DateTime $endDate;

    public bool $isRecurring;

    public User $createdBy;

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function getEventName(): string
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

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function isRecurring(): bool
    {
        return $this->isRecurring;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }
}
