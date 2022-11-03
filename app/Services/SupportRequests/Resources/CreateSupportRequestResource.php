<?php

declare(strict_types=1);

namespace App\Services\SupportRequests\Resources;

use App\Enum\SupportRequestStatusEnum;
use App\Models\Client;
use App\Models\Department;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateSupportRequestResource extends DataTransferObject
{
    public Client $client;

    public Department $department;

    public User $createdBy;

    public string $message;

    public SupportRequestStatusEnum $statusEnum;

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getStatus(): SupportRequestStatusEnum
    {
        return $this->statusEnum;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function setDepartment(Department $department): self
    {
        $this->department = $department;
        return $this;
    }

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function setStatusEnum(SupportRequestStatusEnum $statusEnum): self
    {
        $this->statusEnum = $statusEnum;
        return $this;
    }
}
