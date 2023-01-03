<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Tickets;

use App\Enum\TicketPrioritiesEnum;
use App\Enum\TicketTypeEnum;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Validation\Rule;

final class CreateTicketSupportRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getClientId(): int
    {
        return $this->getInt('client_id');
    }

    public function getDepartmentId(): int
    {
        return $this->getInt('department_id');
    }

    public function getDescription(): string
    {
        return $this->getString('description');
    }

    public function getDueDate(): ?DateTimeInterface
    {
        $duedate = $this->getString('duedate');

        if ($duedate === null) {
            return null;
        }

        return new Carbon($duedate);
    }

    public function getSubject(): string
    {
        return $this->getString('subject');
    }

    public function getType(): TicketTypeEnum
    {
        $type = $this->getString('type');

        return new TicketTypeEnum($type);
    }

    public function getRequestedBy(): int
    {
        return $this->getInt('requested_by');
    }

    public function getPriority(): TicketPrioritiesEnum
    {
        return new TicketPrioritiesEnum($this->getString('priority'));
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'client_id' => 'int|required|exists:App\Models\Client,id',
            'department_id' => 'int|required|exists:App\Models\Department,id',
            'description' => 'json',
            'duedate' => 'date|nullable',
            'priority' => [
                'string',
                Rule::in(TicketPrioritiesEnum::toArray()),
            ],
            'subject' => 'string|required',
            'requested_by' => 'int|required|exists:App\Models\User,id',
            'type' => [
                'required',
                'string',
                Rule::in(TicketTypeEnum::toArray()),
            ],
        ];
    }
}
