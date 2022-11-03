<?php

declare(strict_types=1);

namespace App\Http\Requests\API\SupportRequests;

use App\Http\Requests\BaseRequest;

final class CreateSupportRequestRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getDepartmentId(): int
    {
        return $this->getInt('department_id');
    }

    public function getMessage(): string
    {
        return $this->getString('message');
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'department_id' => 'int|required|exists:App\Models\Department,id',
            'message' => 'string|required',
        ];
    }
}
