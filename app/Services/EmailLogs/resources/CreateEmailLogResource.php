<?php

declare(strict_types=1);

namespace App\Services\EmailLogs\resources;

use App\Enum\EmailStatusEnum;
use App\Models\Emails\Interfaces\EmailInterface;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateEmailLogResource extends DataTransferObject
{
    public EmailInterface $emailType;

    public EmailStatusEnum $status;

    public ?string $cc = null;

    public ?string $failedDetails = null;

    public string $message;

    public string $to;

    public function getEmailType(): EmailInterface
    {
        return $this->emailType;
    }

    public function getStatus(): EmailStatusEnum
    {
        return $this->status;
    }

    public function getCc(): ?string
    {
        return $this->cc;
    }

    public function getFailedDetails(): ?string
    {
        return $this->failedDetails;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function setEmailType(EmailInterface $emailType): self
    {
        $this->emailType = $emailType;

        return $this;
    }

    public function setStatus(EmailStatusEnum $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setCc(?string $cc): self
    {
        $this->cc = $cc;

        return $this;
    }

    public function setFailedDetails(?string $failedDetails): self
    {
        $this->failedDetails = $failedDetails;

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function setTo(string $to): self
    {
        $this->to = $to;

        return $this;
    }
}
