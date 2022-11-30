<?php

namespace App\Http\Requests\API\Tickets;

use App\Http\Requests\BaseRequest;

final class CreateTicketEmailRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getCc(): ?string
    {
        return $this->getString('cc');
    }

    public function getMessage(): string
    {
        return $this->getString('message');
    }

    public function getTitle(): string
    {
        return $this->getString('title');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'cc' => 'nullable|string',
            'message' => 'json|required',
            'title' => 'required|string',
        ];
    }
}
