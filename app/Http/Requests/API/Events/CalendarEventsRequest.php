<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Events;

use App\Http\Requests\BaseRequest;

final class CalendarEventsRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'month' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12',
            'year' => 'required|integer|min:2020|max:3000',
        ];
    }
}
