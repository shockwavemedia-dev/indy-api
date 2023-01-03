<?php

declare(strict_types=1);

namespace App\Services\SMS\Resources;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class SmsMessagesResponse extends DataTransferObject
{
    public ?array $error;

    public ?array $messages;

    public ?array $page;

    public ?int $total;

    public function getError(): ?array
    {
        return $this->error;
    }

    public function getMessages(): ?array
    {
        return $this->messages;
    }

    public function getPage(): ?array
    {
        return $this->page;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setError(?array $error): self
    {
        $this->error = $error;

        return $this;
    }

    public function setMessages(?array $messages): self
    {
        $this->messages = $messages;

        return $this;
    }

    public function setPage(?array $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function setTotal(?int $total): self
    {
        $this->total = $total;

        return $this;
    }
}
