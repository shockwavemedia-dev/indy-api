<?php

declare(strict_types=1);

namespace App\Services\Printers\Resources;

use App\Models\File;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

final class CreatePrinterResource extends DataTransferObject
{
    public User $createdBy;

    public ?File $logo = null;

    public string $companyName;

    public string $email;

    public string $password;

    public ?string $contactName = null;

    public ?string $phone = null;

    public ?string $description = null;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    public function getLogo(): ?File
    {
        return $this->logo;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
