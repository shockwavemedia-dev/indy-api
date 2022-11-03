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

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'department_ids' => 'string',
            'status' => 'string',
            'types' => 'string',
        ];
    }
}
