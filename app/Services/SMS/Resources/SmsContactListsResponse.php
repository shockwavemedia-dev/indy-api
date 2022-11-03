<?php

declare(strict_types=1);

namespace App\Services\SMS\Resources;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class SmsContactListsResponse extends DataTransferObject
{
    public ?array $page;

    public ?int $lists_total;

    public ?array $lists;

    public ?array $error;

    public function getPage(): ?array
    {
        return $this->page;
    }

    public function getListsTotal(): ?int
    {
        return $this->lists_total;
    }

    public function getLists(): ?array
    {
        return $this->lists;
    }

    public function getError(): ?array
    {
        return $this->error;
    }

    public function setPage(?array $page): self
    {
        $this->page = $page;
        return $this;
    }

    public function setListsTotal(?int $lists_total): self
    {
        $this->lists_total = $lists_total;
        return $this;
    }

    public function setLists(?array $lists): self
    {
        $this->lists = $lists;
        return $this;
    }

    public function setError(?array $error): self
    {
        $this->error = $error;
        return $this;
    }
}
