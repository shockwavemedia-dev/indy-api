<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Departments;

use App\Http\Requests\BaseRequest;

final class AddDepartmentMembersRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getAdminUserIds(): array
    {
        return $this->getArray('admin_users');
    }

    public function rules(): array
    {
        return [
            'admin_users' => 'array|required',
            'admin_users.*' => 'integer|exists:App\Models\Users\AdminUser,id',
        ];
    }
}
