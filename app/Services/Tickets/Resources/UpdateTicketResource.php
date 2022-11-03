<?php

declare(strict_types=1);

namespace App\Services\Tickets\Resources;

use App\Enum\TicketPrioritiesEnum;
use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
use App\Models\User;
use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class UpdateTicketResource extends DataTransferObject
{
    public string $subject;

    public TicketPrioritiesEnum $priority;

    public string $description;

    public ?DateTimeInterface $dueDate = null;

    public TicketTypeEnum $type;

    public User $updatedBy;

    public TicketStatusEnum $status;

    public function getPriority(): TicketPrioritiesEnum
    {
        return $this->priority;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDueDate(): ?DateTimeInterface
    {
        return $this->dueDate;
    }

    public function getType(): TicketTypeEnum
    {
        return $this->type;
    }

    public function getUpdatedBy(): User
    {
        return $this->updatedBy;
    }

    public function getStatus(): TicketStatusEnum
    {
        return $this->status;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setDueDate(?DateTimeInterface $dueDate = null): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function setType(TicketTypeEnum $type): self
    {
        $this->type = $type->getValue();
        return $this;
    }

    public function setUpdatedBy(User $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function setStatus(TicketStatusEnum $status): self
    {
        $this->status = $status->getValue();
        return $this;
    }
}
