<?php

declare(strict_types=1);

namespace App\Http\Requests\API\LibraryCategories;

use App\Http\Requests\BaseRequest;

final class CreateLibraryCategoryRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->getString('name');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:App\Models\LibraryCategory,name',
        ];
    }
}
