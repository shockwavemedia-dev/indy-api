<?php

namespace App\Http\Requests\API\TicketNotes;

use App\Http\Requests\BaseRequest;

final class UpdateTicketNoteRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getNote(): string
    {
        return $this->getString('note');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'note' => 'required|json'
        ];
    }
}
