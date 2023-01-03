<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Folders;

use App\Http\Requests\BaseRequest;

final class UpdateFolderRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->getString('name');
    }

    public function getParentFolderId(): ?int
    {
        $id = $this->getInt('parent_folder_id');

        if ($id === 0) {
            return null;
        }

        return $id;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'parent_folder_id' => 'int|nullable|exists:App\Models\Folder,id',
        ];
    }
}
