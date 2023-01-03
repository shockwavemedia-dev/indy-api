<?php

declare(strict_types=1);

namespace App\Services\Departments\Resources;

use App\Enum\DepartmentStatusEnum;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateDepartmentResources extends DataTransferObject
{
    public string $name;

    public ?string $description;

    public ?int $minDeliveryDays = null;

    /**
     * @var int[]
     */
    public ?array $serviceIds = null;

    public DepartmentStatusEnum $status;

    public function getName(): string
    {
        return $this->name;
    }

    public function getMinDeliveryDays(): ?int
    {
        return $this->minDeliveryDays;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int[]
     */
    public function getServiceIds(): ?array
    {
        return $this->serviceIds;
    }

    public function getStatus(): DepartmentStatusEnum
    {
        return $this->status;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setMinDeliveryDays(?int $minDeliveryDays = null): self
    {
        $this->minDeliveryDays = $minDeliveryDays;

        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setStatus(DepartmentStatusEnum $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setServiceIds(?array $serviceIds = null): self
    {
        $this->serviceIds = $serviceIds;

        return $this;
    }
}
