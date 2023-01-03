<?php

namespace App\Http\Requests\API\Departments;

use App\Http\Requests\API\PaginationRequest;

final class DepartmentListRequest extends PaginationRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function withUsers(): bool
    {
        $withUser = $this->getString('with_users') ?? false;

        return filter_var($withUser, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'with_users' => '',
        ];
    }
}
