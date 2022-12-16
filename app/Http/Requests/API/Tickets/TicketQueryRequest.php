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
        $status = $this->getString('status');

        if ($status === null) {
            return null;
        }

        return explode(',', $status) ?? null;
    }

    public function getTypes(): ?array
    {
        $types = $this->getString('types');

        if ($types === null) {
            return null;
        }

        return explode(',', $types) ?? null;
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
        $priority = $this->getString('priority');

        if ($priority === null) {
            return null;
        }

        return explode(',', $priority) ?? null;
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'department_ids' => 'string',
            'status' => 'string',
            'types' => 'string',
            'client_id' => 'int|nullable|exists:App\Models\Client,id',
            'priority'  => 'string'
        ];
    }
}
