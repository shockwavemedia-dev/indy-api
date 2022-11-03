<?php

declare(strict_types=1);

namespace App\Services\ClientServices\Resources;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateClientServiceResource extends DataTransferObject
{
    public int $clientId;

    public int $serviceId;

    public ?array $extras = [];

    public int $createdById;

    public function getClientId(): int
    {
        return $this->clientId;
    }

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function getExtras(): ?array
    {
        return $this->extras;
    }

    public function getCreatedById(): int
    {
        return $this->createdById;
    }

    public function setClientId(int $clientId): self
    {
        $this->clientId = $clientId;

        return $this;
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

    public function setCreatedById(int $createdById): self
    {
        $this->createdById = $createdById;

        return $this;
    }
}
