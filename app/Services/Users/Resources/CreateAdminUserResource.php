<?php

declare(strict_types=1);

namespace App\Services\Users\Resources;

use App\Enum\AdminRoleEnum;
use App\Models\Department;
use App\Services\Users\Interfaces\CreateUserTypeResourceInterface;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateAdminUserResource extends DataTransferObject implements CreateUserTypeResourceInterface
{
    public AdminRoleEnum $role;

    public ?int $departmentId = null;

    public ?string $position = null;

    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    public function getRole(): string
    {
        return $this->role->getValue();
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function setDepartmentId(?int $departmentId = null): self
    {
        $this->departmentId = $departmentId;

        return $this;
    }

    public function setRole(AdminRoleEnum $role): self
    {
        $this->role = $role;

        return $this;
    }
}
