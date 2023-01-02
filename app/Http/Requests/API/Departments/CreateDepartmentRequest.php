<?php

namespace App\Http\Requests\API\Departments;

use App\Enum\DepartmentStatusEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class CreateDepartmentRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getMinDeliveryDays(): ?int
    {
        return $this->getInt('min_delivery_days') ?? 0;
    }

    public function getDescription(): ?string
    {
        return $this->getString('description');
    }

    public function getName(): string
    {
        return $this->getString('name');
    }

    public function getStatus(): ?string
    {
        return $this->getString('status');
    }

    public function getServiceIds(): ?array
    {
        if ($this->has('services') === false) {
            return null;
        }

        return $this->getArray('services') ?? [];
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:App\Models\Department,name',
            'description' => 'string|nullable',
            'min_delivery_days',
            'password' => [
                'string',
                Rule::in(DepartmentStatusEnum::toArray()),
            ],
            'services' => 'required|array',
            'services.*' => 'integer|exists:App\Models\Service,id',
        ];
    }
}
