<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Tickets;

use App\Enum\TicketPrioritiesEnum;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Validation\Rule;

final class CreateTicketEventRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getClientId(): int
    {
        return $this->getInt('client_id');
    }

    public function getDescription(): ?string
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

    public function getServices(): array
    {
        return $this->getArray('services');
    }

    public function getSubject(): string
    {
        return $this->getString('subject');
    }

    public function getRequestedBy(): int
    {
        return $this->getInt('requested_by');
    }

    public function getAttachments(): array
    {
        return $this->file('attachments') ?? [];
    }

    public function getMarketingPlannerStartDate(): ?DateTimeInterface
    {
        if ($this->getString('marketing_plan_start_date') === null) {
            return null;
        }

        return new Carbon($this->getString('marketing_plan_start_date'));
    }

    public function getMarketingPlannerEndDate(): ?DateTimeInterface
    {
        if ($this->getString('marketing_plan_end_date') === null) {
            return null;
        }

        return new Carbon($this->getString('marketing_plan_end_date'));
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
            'description' => 'string',
            'duedate' => 'date|nullable',
            'priority' => [
                'required',
                'string',
                Rule::in(TicketPrioritiesEnum::toArray()),
            ],
            'services' => 'array',
            'subject' => 'string|required',
            'requested_by' => 'int|required|exists:App\Models\User,id',
            'marketing_plan_start_date' => 'date|nullable',
            'marketing_plan_end_date' => 'date|nullable',
        ];
    }
}
