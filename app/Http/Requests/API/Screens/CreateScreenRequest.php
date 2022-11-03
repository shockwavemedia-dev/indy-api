<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Screens;

use App\Http\Requests\BaseRequest;

final class CreateScreenRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|required|unique:App\Models\Screen,name',
            'logo' => '',
        ];
    }
}
