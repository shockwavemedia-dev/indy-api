<?php

declare(strict_types=1);

namespace App\Services\ClientTicketFiles\Resources;

use App\Enum\TicketFileStatusEnum;
use App\Models\Client;
use App\Models\File;
use App\Models\Tickets\Ticket;
use App\Models\User;
use App\Models\Users\AdminUser;
use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateClientTicketFileResource extends DataTransferObject
{
    public File $file;

    public ?Client $client = null;

    public Ticket $ticket;

    public TicketFileStatusEnum $statusEnum;

    public ?string $description = null;

    public AdminUser $assignedStaff;

    public ?User $approvedBy = null;

    public ?DateTimeInterface $approvedAt = null;

    public function getFile(): File
    {
        return $this->file;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function getStatusEnum(): TicketFileStatusEnum
    {
        return $this->statusEnum;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getAssignedStaff(): AdminUser
    {
        return $this->assignedStaff;
    }

    public function getApprovedBy(): ?User
    {
        return $this->approvedBy;
    }

    public function getApprovedAt(): ?DateTimeInterface
    {
        return $this->approvedAt;
    }

    public function setFile(File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function setClient(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function setTicket(Ticket $ticket): self
    {
        $this->ticket = $ticket;

        return $this;
    }

    public function setStatusEnum(TicketFileStatusEnum $statusEnum): self
    {
        $this->statusEnum = $statusEnum;

        return $this;
    }

    public function setDescription(?string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    public function setAssignedStaff(AdminUser $assignedStaff): self
    {
        $this->assignedStaff = $assignedStaff;

        return $this;
    }

    public function setApprovedBy(?User $approvedBy): self
    {
        $this->approvedBy = $approvedBy;

        return $this;
    }

    public function setApprovedAt(?DateTimeInterface $approvedAt): self
    {
        $this->approvedAt = $approvedAt;

        return $this;
    }
}
