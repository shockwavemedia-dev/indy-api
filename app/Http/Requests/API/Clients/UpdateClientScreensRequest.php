<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Clients;

use App\Http\Requests\BaseRequest;

final class UpdateClientScreensRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getScreenIds(): array
    {
        return $this->getArray('screen_ids');
    }

    public function rules(): array
    {
        return [
            'screen_ids' => 'array',
            'screen_ids*' => 'int|exists:App\Models\Screen,id',
        ];
    }
}
