<?php

declare(strict_types=1);

namespace App\Http\Requests\API\ContactUs;

use App\Http\Requests\BaseRequest;

final class SendEmailInfoRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'string|required',
            'contact_number' => 'string|nullable',
            'inquiry' => 'string|nullable',
        ];
    }
}
