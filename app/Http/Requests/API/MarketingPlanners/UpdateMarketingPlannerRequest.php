<?php

declare(strict_types=1);

namespace App\Http\Requests\API\MarketingPlanners;

use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTime;

final class UpdateMarketingPlannerRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function getDescription(): ?string
    {
        return $this->getString('description');
    }

    public function getEventName(): ?string
    {
        return $this->getString('event_name');
    }

    public function getTodoList(): ?array
    {
        return $this->getArray('todo_list');
    }

    public function getStartDate(): ?Carbon
    {
        $startDate = $this->getString('start_date');

        if ($startDate === null) {
            return null;
        }

        return new Carbon($startDate);
    }

    public function getEndDate(): ?Carbon
    {
        $endDate = $this->getString('end_date');

        if ($endDate === null) {
            return null;
        }

        return new Carbon($endDate);
    }

    public function isRecurring(): ?bool
    {
        if ($this->get('is_recurring') === null) {
            return null;
        }

        return $this->boolean('is_recurring');
    }

    public function getAttachments(): ?array
    {
        return $this->file('attachments');
    }

    public function rules(): array
    {
        return [
            'event_name' => 'string|nullable',
            'description' => 'string|nullable',
            'todo_list' => 'array|nullable',
            'todo_list.*.id' => 'int|exists:App\Models\MarketingPlannerTask,id',
            'todo_list.*.name' => 'string',
            'todo_list.*.assignee' => 'string',
            'todo_list.*.deadline' => 'date',
            'todo_list.*.status' => 'string',
            'todo_list.*.notify' => 'nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
            'is_recurring' => 'nullable',
            'attachments' => '',
        ];
    }
}
