<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Users;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;
use App\Enum\UserTypeEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

final class CreateAdminUserRequest extends AbstractCreateUserRequest
{
    public function getPosition(): ?string
    {
        return $this->getString('position');
    }

    public function getDepartmentId(): ?int
    {
        $departmentId = $this->getInt('department_id');

        if ($departmentId === 0) {
            return null;
        }

        return $departmentId;
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
        return [
            'display_in_dashboard' => 'nullable',
            'profile_photo' => 'nullable',
            'contact_number' => 'required|string',
            'email' => 'required|string|unique:App\Models\User,email',
            'first_name' => 'required|string',
            'gender' => 'string|nullable',
            'position' => 'string|nullable',
            'last_name' => 'string|nullable',
            'middle_name' => 'string|nullable',
            'password' => 'min:6|required_if:send_invite,false|required_with:password_confirmation|same:password_confirmation|nullable|string',
            'password_confirmation' => 'required_if:send_invite,false',
            'role' => [
                'string',
                Rule::in(AdminRoleEnum::toArray()),
            ],
            'department_id' => 'int|nullable|exists:App\Models\Department,id',
        ];
    }
}
