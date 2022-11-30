<?php

declare(strict_types=1);

namespace App\Services\TicketEmails\Resources;

use App\Enum\TicketEmailStatusEnum;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateTicketEmailResource extends DataTransferObject
{
    public ?int $clientId;

    public ?int $senderBy;

    public ?string $cc = null;

    public string $message;

    public string $senderType;

    public ?int $ticketId;

    public string $title;

    public TicketEmailStatusEnum $status;

    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    public function getTicketId(): ?int
    {
        return $this->ticketId;
    }

    public function getSenderBy(): ?int
    {
        return $this->senderBy;
    }

    public function getCc(): ?string
    {
        return $this->cc;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getSenderType(): ?string
    {
        return $this->senderType;
    }

    public function getStatus(): TicketEmailStatusEnum
    {
        return $this->status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setClientId(?int $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function setTicketId(?int $ticketId): self
    {
        $this->ticketId = $ticketId;

        return $this;
    }

    public function setSenderBy(?int $senderBy): self
    {
        $this->senderBy = $senderBy;

        return $this;
    }

    public function setCc(string $cc): self
    {
        $this->cc = $cc;

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function setSenderType(string $senderType): self
    {
        $this->senderType = $senderType;

        return $this;
    }

    public function setStatus(TicketEmailStatusEnum $status): self
    {
        $this->status = $status->getValue();

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
