<?php

declare(strict_types=1);

namespace App\Http\Requests\API\TicketChats;

use App\Http\Requests\BaseRequest;

final class CreateTicketChatRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getMessage(): string
    {
        return $this->getString('message');
    }

    public function getTaggedUsers(): ?array
    {
        return $this->get('users_tagged');
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string',
            'users_tagged' => 'array|nullable',
        ];
    }
}
