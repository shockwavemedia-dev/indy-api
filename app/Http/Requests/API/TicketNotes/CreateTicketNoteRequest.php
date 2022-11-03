<?php

declare(strict_types=1);

namespace App\Http\Requests\API\TicketNotes;

use App\Http\Requests\BaseRequest;

final class CreateTicketNoteRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getNote(): string
    {
        return $this->getString('note');
    }

    public function rules(): array
    {
        return [
            'note' => 'required|json'
        ];
    }
}
