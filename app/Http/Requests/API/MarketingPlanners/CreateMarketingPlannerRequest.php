<?php

declare(strict_types=1);

namespace App\Http\Requests\API\MarketingPlanners;

use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTime;

final class CreateMarketingPlannerRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function getEventName(): string
    {
        return $this->getString('event_name');
    }

    public function getDescription(): ?string
    {
        return $this->getString('description');
    }

    public function getTodoList(): ?array
    {
        return $this->getArray('todo_list');
    }

    public function getStartDate(): DateTime
    {
        return new Carbon($this->getString('start_date'));
    }

    public function getEndDate(): DateTime
    {
        return new Carbon($this->getString('end_date'));
    }

    public function isRecurring(): bool
    {
        return $this->boolean('is_recurring');
    }

    public function getAttachments(): ?array
    {
        return $this->file('attachments');
    }

    public function rules(): array
    {
        return [
            'event_name' => 'string|required',
            'description' => 'string|nullable',
            'todo_list' => 'array|nullable',
            'todo_list.*.name' => 'string',
            'todo_list.*.assignee' => 'string',
            'todo_list.*.deadline' => 'date',
            'todo_list.*.status' => 'string',
            'todo_list.*.notify' => 'nullable',
            'start_date' => 'date|required',
            'end_date' => 'date|required',
            'is_recurring' => 'required',
            'attachments' => '',
        ];
    }
}
