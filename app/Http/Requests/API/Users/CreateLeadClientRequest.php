<?php

namespace App\Http\Requests\API\Users;

use App\Http\Requests\BaseRequest;

final class CreateLeadClientRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getCompanyName(): string
    {
        return $this->getString('company_name');
    }

    public function getEmail(): string
    {
        return $this->getString('email');
    }

    public function getFullName(): string
    {
        return $this->getString('full_name');
    }

    public function getPassword(): string
    {
        return $this->getString('password');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'company_name' => 'required|string',
            'email' => 'required|string|unique:App\Models\User,email',
            'full_name' => 'required|string',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        ];
    }
}
