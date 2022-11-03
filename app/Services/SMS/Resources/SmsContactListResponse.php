<?php

declare(strict_types=1);

namespace App\Services\SMS\Resources;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class SmsContactListResponse extends DataTransferObject
{
    public ?string $created;

    public ?array $error;

    public ?array $fields;

    public ?int $id;

    public ?array $members;

    public ?int $members_active;

    public ?int $members_total;

    public ?string $name;

    public ?array $page;

    public function getCreated(): ?string
    {
        return $this->created;
    }

    public function getError(): ?array
    {
        return $this->error;
    }

    public function getFields(): ?array
    {
        return $this->fields;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMembers(): ?array
    {
        return $this->members;
    }

    public function getMembersActive(): ?int
    {
        return $this->members_active;
    }

    public function getMembersTotal(): ?int
    {
        return $this->members_total;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPage(): ?array
    {
        return $this->page;
    }

    public function setCreated(?string $created): self
    {
        $this->created = $created;
        return $this;
    }

    public function setError(?array $error): self
    {
        $this->error = $error;
        return $this;
    }

    public function setFields(?array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setMembers(?array $members): self
    {
        $this->members = $members;
        return $this;
    }

    public function setMembersActive(?int $members_active): self
    {
        $this->members_active = $members_active;
        return $this;
    }

    public function setMembersTotal(?int $members_total): self
    {
        $this->members_total = $members_total;
        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setPage(?array $page): self
    {
        $this->page = $page;
        return $this;
    }
}
