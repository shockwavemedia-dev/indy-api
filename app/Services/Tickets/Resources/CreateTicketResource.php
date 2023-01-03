<?php

declare(strict_types=1);

namespace App\Services\Tickets\Resources;

use App\Enum\TicketPrioritiesEnum;
use App\Enum\TicketTypeEnum;
use App\Enum\UserTypeEnum;
use App\Models\Client;
use App\Models\Department;
use App\Models\User;
use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateTicketResource extends DataTransferObject
{
    public ?array $emailHtml = null;

    public TicketPrioritiesEnum $priority;

    public Client $client;

    public User $createdBy;

    public ?string $description = null;

    public ?Department $department = null;

    public ?DateTimeInterface $dueDate = null;

    public string $subject;

    /**
     * @return TicketPrioritiesEnum
     */
    public function getPriority(): TicketPrioritiesEnum
    {
        return $this->priority;
    }

    public User $requestedBy;

    public ?array $attachments = null;

    public ?array $services = [];

    public TicketTypeEnum $type;

    public ?DateTimeInterface $marketingPlannerStartDate = null;

    public ?DateTimeInterface $marketingPlannerEndDate = null;

    public function getMarketingPlannerStartDate(): ?DateTimeInterface
    {
        return $this->marketingPlannerStartDate;
    }

    public function getEmailHtml(): ?array
    {
        return $this->emailHtml;
    }

    public function getMarketingPlannerEndDate(): ?DateTimeInterface
    {
        return $this->marketingPlannerEndDate;
    }

    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDueDate(): ?DateTimeInterface
    {
        return $this->dueDate;
    }

    public function getServices(): ?array
    {
        return $this->services;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getRequestedBy(): User
    {
        return $this->requestedBy;
    }

    public function getType(): TicketTypeEnum
    {
        return $this->type;
    }

    public function getUserType(): UserTypeEnum
    {
        return $this->createdBy->getUserType()->getType();
    }

    public function setAttachment(?array $attachments = null): self
    {
        $this->attachments = $attachments;

        return $this;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function setCreatedBy(User $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function setDepartment(?Department $department = null): CreateTicketResource
    {
        $this->department = $department;

        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setDueDate(?DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @param  mixed[]|null  $services
     */
    public function setServices(?array $services = []): self
    {
        $this->services = $services;

        return $this;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function setRequestedBy(User $requestedBy): self
    {
        $this->requestedBy = $requestedBy;

        return $this;
    }

    public function setUserType(UserTypeEnum $userType): self
    {
        $this->userType = $userType;

        return $this;
    }
}
