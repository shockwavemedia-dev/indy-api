<?php

namespace App\Http\Requests\API\Users;

use App\Http\Requests\BaseRequest;

final class ResetPasswordRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getEmail(): string
    {
        return $this->getString('email');
    }

    public function getPassword(): string
    {
        return $this->getString('password');
    }

    public function getToken(): string
    {
        return $this->getString('token');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
            'token' => 'required|string',
        ];
    }
}
