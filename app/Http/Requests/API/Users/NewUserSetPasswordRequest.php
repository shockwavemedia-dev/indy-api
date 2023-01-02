<?php

namespace App\Http\Requests\API\Users;

use App\Http\Requests\BaseRequest;

final class NewUserSetPasswordRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getEmail(): string
    {
        return $this->getString('email');
    }

    public function getToken(): string
    {
        return $this->getString('token');
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
            'email' => 'required|string',
            'token' => 'required|string',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation|required|string',
            'password_confirmation' => 'min:6',
        ];
    }
}
