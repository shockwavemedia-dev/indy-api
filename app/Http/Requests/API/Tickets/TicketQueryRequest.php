<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Tickets;

use App\Http\Requests\API\PaginationRequest;

final class TicketQueryRequest extends PaginationRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getDepartmentIds(): ?array
    {
        $departmentIds = $this->getString('department_ids');

        if ($departmentIds === null) {
            return null;
        }

        return explode(',', $departmentIds) ?? null;
    }

    public function getStatuses(): ?array
    {
        if ($this->get('statuses') === null) {
            return null;
        }

        return $this->getArray('statuses');
    }

    public function getTypes(): ?array
    {
        if ($this->get('types') === null) {
            return null;
        }

        return $this->getArray('types');
    }

    public function getClientId(): ?int
    {
        $clientId = $this->getInt('client_id');

        if ($clientId === 0) {
            return null;
        }

        return $clientId;
    }

    public function getPriorities(): ?array
    {
        if ($this->get('priorities') === null) {
            return null;
        }

        return $this->getArray('priorities');
    }

    public function getSubject(): ?string
    {
        if ($this->get('subject') === null) {
            return null;
        }

        return $this->getString('subject');
    }

    public function getCode(): ?string
    {
        if ($this->get('code') === null) {
            return null;
        }

        return $this->getString('code');
    }

    public function hideClosed(): ?bool
    {
        if ($this->get('hide_closed') === null) {
            return null;
        }

        return $this->boolean('hide_closed');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'department_ids' => 'string',
            'statuses' => 'array|nullable',
            'types' => 'array|nullable',
            'client_id' => 'int|nullable|exists:App\Models\Client,id',
            'priorities' => 'array|nullable',
            'subject' => 'string|nullable',
            'code' => 'string|nullable',
        ];
    }
}
