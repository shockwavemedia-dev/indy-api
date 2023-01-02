<?php

namespace App\Http\Requests\API\Authentication;

use App\Http\Requests\BaseRequest;

final class RefreshTokenRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getRefreshToken(): string
    {
        return $this->getString('refresh_token');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'refresh_token' => 'required|string',
        ];
    }
}
