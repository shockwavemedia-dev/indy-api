<?php

declare(strict_types=1);

namespace App\Services\FileFeedbacks\Resources;

use Spatie\DataTransferObject\DataTransferObject;

final class CreateFileFeedbackResource extends DataTransferObject
{
    public ?int $clientTicketFile;

    public ?int $feedbackBy;

    public string $feedback;

    public string $feedbackByType;

    public function getClientTicketFile(): ?int
    {
        return $this->clientTicketFile;
    }

    public function getFeedbackBy(): ?int
    {
        return $this->feedbackBy;
    }

    public function getFeedback(): ?string
    {
        return $this->feedback;
    }

    public function getFeedbackByType(): ?string
    {
        return $this->feedbackByType;
    }

    public function setClientTicketFile(?int $clientTicketFile): self
    {
        $this->clientTicketFile = $clientTicketFile;

        return $this;
    }

    public function setFeedbackBy(?int $feedbackBy): self
    {
        $this->feedbackBy = $feedbackBy;

        return $this;
    }

    public function setFeedback(string $feedback): self
    {
        $this->feedback = $feedback;

        return $this;
    }

    public function setFeedbackByType(string $feedbackByType): self
    {
        $this->feedbackByType = $feedbackByType;

        return $this;
    }
}
