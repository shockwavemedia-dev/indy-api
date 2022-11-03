<?php

declare(strict_types=1);

namespace App\Services\Users\Resources;

use App\Services\Users\Interfaces\CreateUserTypeResourceInterface;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateLeadClientResource extends DataTransferObject implements CreateUserTypeResourceInterface
{
    public string $companyName;

    public string $fullName;

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getRole(): string
    {
        return 'n/a';
    }
}
