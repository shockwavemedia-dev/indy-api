<?php

declare(strict_types=1);

namespace App\Services\ErrorLogs\Resources;

use Spatie\DataTransferObject\DataTransferObject;

final class CreateErrorLogResource extends DataTransferObject
{
    public string $context;

    public string $level;

    public string $message;

    public function getContext(): string
    {
        return $this->context;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setContext(string $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
