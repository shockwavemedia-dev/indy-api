<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Clients;

use App\Enum\TicketTypeEnum;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Validation\Rule;

final class CreateTicketSupportByClientRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
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

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'department_id' => 'int|required|exists:App\Models\Department,id',
            'description' => 'string',
            'duedate' => 'date',
            'subject' => 'string|required',
            'type' => [
                'required',
                'string',
                Rule::in(TicketTypeEnum::toArray()),
            ]
        ];
    }
}
