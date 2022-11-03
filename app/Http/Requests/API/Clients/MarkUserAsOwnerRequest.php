<?php

namespace App\Http\Requests\API\Clients;

use App\Http\Requests\BaseRequest;

final class MarkUserAsOwnerRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getClientUserId(): int
    {
        return $this->getInt('client_user_id');
    }

    public function getId(): int
    {
        return (int) $this->id;
    }
    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'client_user_id' => 'required|int|exists:App\Models\Users\ClientUser,id',
        ];
    }
}
