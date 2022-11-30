<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Users;

use App\Enum\ClientRoleEnum;
use Illuminate\Validation\Rule;

final class CreateClientUserRequest extends AbstractCreateUserRequest
{
    public function getClientId(): int
    {
        return $this->getInt('client_id');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'birth_date' => 'nullable|date',
            'contact_number' => 'nullable|string',
            'email' => 'required|string|unique:App\Models\User,email',
            'first_name' => 'required|string',
            'last_name' => 'nullable|string',
            'send_invite' => 'nullable',
            'password' => 'min:6|required_if:send_invite,false|required_with:password_confirmation|same:password_confirmation|nullable|string',
            'password_confirmation' => 'required_if:send_invite,false',
            'role' => [
                'string',
                'required',
                Rule::in(ClientRoleEnum::toArray()),
            ],
            'client_id' => 'int|required|exists:App\Models\Client,id',
        ];
    }
}
