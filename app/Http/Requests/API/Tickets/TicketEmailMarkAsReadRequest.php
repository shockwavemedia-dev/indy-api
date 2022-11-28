<?php

namespace App\Http\Requests\API\Tickets;

use App\Http\Requests\BaseRequest;

final class TicketEmailMarkAsReadRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getIsRead(): ?int
    {
        return $this->getInt('is_read');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'is_read' => 'int|required',
        ];
    }
}
