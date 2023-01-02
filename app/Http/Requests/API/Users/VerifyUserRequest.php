<?php

namespace App\Http\Requests\API\Users;

use App\Http\Requests\BaseRequest;

final class VerifyUserRequest extends BaseRequest
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

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'token' => 'required|string',
        ];
    }
}
