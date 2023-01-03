<?php

namespace App\Http\Requests\API\Users;

use App\Http\Requests\BaseRequest;

final class ForgotPasswordRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getEmail(): string
    {
        return $this->getString('email');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string',
        ];
    }
}
