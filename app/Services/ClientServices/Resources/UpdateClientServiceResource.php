<?php

declare(strict_types=1);

namespace App\Services\ClientServices\Resources;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class UpdateClientServiceResource extends DataTransferObject
{
    public int $serviceId;

    public ?array $extras = [];

    public int $updatedBy;

    public ?int $marketingQuota = 0;

    public ?int $extraQuota = 0;

    public ?bool $isEnabled = false;

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function getExtras(): ?array
    {
        return $this->extras;
    }

    public function getUpdatedBy(): int
    {
        return $this->updatedBy;
    }

    public function getMarketingQuota(): ?int
    {
        return $this->marketingQuota;
    }

    public function getExtraQuota(): ?int
    {
        return $this->extraQuota;
    }

    public function isEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setServiceId(int $serviceId): self
    {
        $this->serviceId = $serviceId;

        return $this;
    }

    public function setExtras(array $extras = []): self
    {
        $this->extras = $extras;

        return $this;
    }

    public function setUpdatedBy(int $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function setMarketingQuota(int $marketingQuota = 0): self
    {
        $this->marketingQuota = $marketingQuota;

        return $this;
    }

    public function setExtraQuota(int $extraQuota = 0): self
    {
        $this->extraQuota = $extraQuota;

        return $this;
    }

    public function markAsEnabled(bool $isEnabled = false): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }
}
