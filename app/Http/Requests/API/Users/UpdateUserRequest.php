<?php

namespace App\Http\Requests\API\Users;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;
use App\Enum\UserStatusEnum;
use App\Enum\UserTypeEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

final class UpdateUserRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getBirthDate(): ?string
    {
        if ($this->getString('birth_date') === null) {
            return null;
        }

        return $this->getString('birth_date');
    }

    public function getContactNumber(): ?string
    {
        if ($this->getString('contact_number') === null) {
            return null;
        }

        return $this->getString('contact_number');
    }

    public function getDepartmentId(): ?int
    {
        $departmentId = $this->getInt('department_id');

        if ($departmentId === 0) {
            return null;
        }

        return $departmentId;
    }

    public function getEmail(): ?string
    {
        if ($this->getString('email') === null) {
            return null;
        }

        return $this->getString('email');
    }

    public function getFirstName(): ?string
    {
        if ($this->getString('first_name') === null) {
            return null;
        }

        return $this->getString('first_name');
    }

    public function getGender(): ?string
    {
        if ($this->getString('gender') === null) {
            return null;
        }

        return $this->getString('gender');
    }

    public function getLastName(): ?string
    {
        if ($this->getString('last_name') === null) {
            return null;
        }

        return $this->getString('last_name');
    }

    public function getMiddleName(): ?string
    {
        if ($this->getString('middle_name') === null) {
            return null;
        }

        return $this->getString('middle_name');
    }

    public function getRole(): ?string
    {
        if ($this->getString('role') === null) {
            return null;
        }

        return $this->getString('role');
    }

    public function getStatus(): ?UserStatusEnum
    {
        $status = $this->getString('status');

        if ($status === null || $status === '') {
            return null;
        }

        return new UserStatusEnum($status);
    }

    public function getClientId(): ?int
    {
        if ($this->getString('client_id') === null) {
            return null;
        }

        return $this->getInt('client_id');
    }

    public function getId(): int
    {
        return (int) $this->id;
    }

    public function getPosition(): ?string
    {
        return $this->getString('position');
    }

    public function getPassword(): ?string
    {
        return $this->getString('password');
    }

    public function getProfile(): ?UploadedFile
    {
        return $this->file('profile_photo') ?? null;
    }

    public function isDisplayInDashboard(): bool
    {
        return filter_var($this->get('display_in_dashboard'), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        $roles = \array_merge(
            AdminRoleEnum::toArray(),
            ClientRoleEnum::toArray(),
        );

        return [
            'position' => 'string|nullable',
            'birth_date' => 'date',
            'password' => 'nullable|min:6|string',
            'contact_number' => 'string',
            'email' => \sprintf('%s,%s','string|unique:App\Models\User,email',$this->getId()),
            'first_name' => 'string|required',
            'gender' => 'string|nullable',
            'last_name' => 'string|nullable',
            'middle_name' => 'string|nullable',
            'status' => [
                'string',
                Rule::in(UserStatusEnum::toArray())
            ],
            'role' => [
                'string',
                Rule::in($roles)
            ],
            'department_id' => 'int|nullable|exists:App\Models\Department,id',
            'client_id' => 'int|exists:App\Models\Client,id',
        ];
    }
}
