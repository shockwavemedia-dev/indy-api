<?php

declare(strict_types=1);

namespace App\Services\FileFeedbacks\Resources;

use Spatie\DataTransferObject\DataTransferObject;

final class UpdateFileFeedbackResource extends DataTransferObject
{
    public string $feedback;

    public function getFeedback(): ?string
    {
        return $this->feedback;
    }

    public function setFeedback(string $feedback): self
    {
        $this->feedback = $feedback;

        return $this;
    }
}
