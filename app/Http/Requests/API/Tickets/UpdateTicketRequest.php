<?php

namespace App\Http\Requests\API\Tickets;

use App\Enum\TicketPrioritiesEnum;
use App\Enum\TicketStatusEnum;
use App\Enum\TicketTypeEnum;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Validation\Rule;

final class UpdateTicketRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getSubject(): ?string
    {
        return $this->getString('subject');
    }

    public function getDepartmentId(): ?int
    {
        return $this->getInt('department_id');
    }

    public function getDescription(): ?string
    {
        return $this->getString('description');
    }

    public function getDueDate(): ?DateTimeInterface
    {
        $date = $this->getString('duedate');

        if ($date === null) {
            return null;
        }

        return new Carbon($date);
    }

    public function getType(): ?TicketTypeEnum
    {
        $type = $this->getString('type');

        if ($type === null) {
            return null;
        }

        return new TicketTypeEnum($type);
    }

    public function getStatus(): ?TicketStatusEnum
    {
        if ($this->getstring('status') === null) {
            return null;
        }

        return new TicketStatusEnum($this->getString('status'));
    }

    public function getPriority(): ?TicketPrioritiesEnum
    {
        if ($this->getstring('priority') === null) {
            return null;
        }

        return new TicketPrioritiesEnum($this->getString('priority'));
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'priority' => [
                'nullable',
                'string',
                Rule::in(TicketPrioritiesEnum::toArray())
            ],
            'subject' => 'string',
            'department_id' => 'int|exists:App\Models\Department,id',
            'description' => 'string',
            'type' => [
                'string',
                Rule::in(TicketTypeEnum::toArray())
            ],
            'duedate' => 'date',
            'status' => [
                'string',
                Rule::in(TicketStatusEnum::toArray())
            ]
        ];
    }
}
