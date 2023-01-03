<?php

declare(strict_types=1);

namespace App\Services\MailChimp\Resources;

use Spatie\DataTransferObject\DataTransferObject;

final class ListResource extends DataTransferObject
{
    public string $id;

    public string $name;

    public int $memberCount;

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMemberCount(): int
    {
        return $this->memberCount;
    }
}
