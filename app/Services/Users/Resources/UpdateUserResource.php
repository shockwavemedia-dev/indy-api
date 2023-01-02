<?php

declare(strict_types=1);

namespace App\Services\Users\Resources;

use App\Enum\UserStatusEnum;
use App\Models\Client;
use App\Models\File;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class UpdateUserResource extends DataTransferObject
{
    public bool $displayInDashboard = false;

    public ?File $profileFile = null;

    public ?string $position = null;

    public ?string $birthDate = null;

    public ?string $contactNumber = null;

    public ?Client $client = null;

    public string $email;

    public ?string $password = null;

    public ?int $departmentId = null;

    public string $firstName;

    public ?string $gender;

    public string $lastName;

    public ?string $middleName = null;

    public string $role;

    public UserStatusEnum $status;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function isDisplayInDashboard(): bool
    {
        return $this->displayInDashboard;
    }

    public function getProfileFile(): ?File
    {
        return $this->profileFile;
    }

    public function getBirthDate(): ?string
    {
        return $this->birthDate;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function getContactNumber(): ?string
    {
        return $this->contactNumber;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getStatus(): UserStatusEnum
    {
        return $this->status;
    }

    public function setBirthDate(?string $birthDate = null): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function setContactNumber(?string $contactNumber): self
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function setDepartmentId(?int $departmentId = null): self
    {
        $this->departmentId = $departmentId;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setGender(?string $gender = null): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setMiddleName(?string $middleName = null): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function setStatus(UserStatusEnum $status): self
    {
        $this->status = $status;

        return $this;
    }
}
