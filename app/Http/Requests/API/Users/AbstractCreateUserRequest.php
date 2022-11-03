<?php

namespace App\Http\Requests\API\Users;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;
use App\Enum\UserTypeEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

abstract class AbstractCreateUserRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getBirthDate(): ?string
    {
        return $this->getString('birth_date');
    }

    public function getContactNumber(): ?string
    {
        return $this->getString('contact_number');
    }

    public function getEmail(): string
    {
        return $this->getString('email');
    }

    public function getFirstName(): string
    {
        return $this->getString('first_name');
    }

    public function getGender(): ?string
    {
        return $this->getString('gender');
    }

    public function getLastName(): ?string
    {
        return $this->getString('last_name');
    }

    public function getMiddleName(): ?string
    {
        return $this->getString('middle_name');
    }

    public function getPassword(): ?string
    {
        return $this->getString('password');
    }

    public function getRole(): string
    {
        return $this->getString('role');
    }
}
