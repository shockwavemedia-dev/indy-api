<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Libraries;

use App\Http\Requests\BaseRequest;

final class ClientCreateLibraryTicketRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getDescription(): ?string
    {
        return $this->getString('description');
    }

    public function rules(): array
    {
        return [
            'description' => 'string',
        ];
    }
}
