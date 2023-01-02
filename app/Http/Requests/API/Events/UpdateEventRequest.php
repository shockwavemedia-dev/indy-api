<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Events;

use App\Enum\EventBookingTypesEnum;
use App\Enum\EventNumberOfDishesEnum;
use App\Enum\EventOutputTypesEnum;
use App\Enum\EventServiceTypesEnum;
use App\Enum\EventShootTypesEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class UpdateEventRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getBackDrops(): string
    {
        return $this->getString('backdrops');
    }

    public function rules(): array
    {
        return [
            'backdrops' => 'string|nullable',
            'booking_type' => [
                'string',
                Rule::in(EventBookingTypesEnum::toArray()),
            ],
            'contact_name' => 'string|nullable',
            'contact_number' => 'string|nullable',
            'department_manager' => 'string|nullable',
            'event_name' => 'string|nullable',
            'job_description' => 'string|nullable',
            'location' => 'string|nullable',
            'number_of_dishes' => [
                'string',
                'nullable',
                Rule::in(EventNumberOfDishesEnum::toArray()),
            ],
            'outputs' => 'array|nullable',
            'outputs.*' => [
                'string',
                Rule::in(EventOutputTypesEnum::toArray()),
            ],
            'preferred_due_date' => 'date|nullable',
            'service_type' => [
                'string',
                Rule::in(EventServiceTypesEnum::toArray()),
            ],
            'shoot_date' => 'date|nullable',
            'shoot_title' => 'string|nullable',
            'start_time' => 'string|nullable',
            'styling_required' => 'nullable',
            'shoot_type' => 'array|nullable',
            'shoot_type.*' => [
                'string',
                Rule::in(EventShootTypesEnum::toArray()),
            ],
        ];
    }
}
