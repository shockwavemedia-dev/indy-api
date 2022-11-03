<?php

declare(strict_types=1);

namespace App\Services\Users\Resources;

use App\Enum\UserStatusEnum;
use App\Models\File;
use App\Models\Users\Interfaces\UserTypeInterface;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class CreateUserResource extends DataTransferObject
{
    public bool $displayInDashboard = false;

    public ?File $profileFile = null;

    public mixed $userType;

    public ?string $birthDate = null;

    public ?string $contactNumber = null;

    public string $email;

    public ?string $firstName = null;

    public ?string $gender = null;

    public ?string $lastName = null;

    public ?string $password = null;

    public ?string $middleName = null;

    public UserStatusEnum $status;

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

    public function getContactNumber(): ?string
    {
        return $this->contactNumber;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }


    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getStatus(): string
    {
        return $this->status->getValue();
    }

    public function getUserType(): mixed
    {
        return $this->userType;
    }

    public function setBirthDate(?string $birthDate = null): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function setContactNumber(?string $contactNumber = null): self
    {
        $this->contactNumber = $contactNumber;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setFirstName(?string $firstName = null): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setGender(?string $gender = null): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function setLastName(?string $lastName = null): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setMiddleName(?string $middleName = null): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function setStatus(UserStatusEnum $status): self
    {
        $this->status = $status->getValue();

        return $this;
    }

    public function setUserType(UserTypeInterface $userType): self
    {
        $this->userType = $userType;

        return $this;
    }
}
