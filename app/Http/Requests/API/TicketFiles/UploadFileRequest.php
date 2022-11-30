<?php

namespace App\Http\Requests\API\TicketFiles;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\UploadedFile;

final class UploadFileRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getFile(): UploadedFile
    {
        return $this->file('file');
    }

    public function getFilePath(): string
    {
        return $this->getString('directory') ?? '';
    }

    public function getFolderId(): ?int
    {
        $id = $this->getInt('folder_id');

        if ($id === 0) {
            return null;
        }

        return $id;
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'file' => 'required',
            'directory' => 'string',
            'folder_id' => 'int|nullable|exists:App\Models\Folder,id',
        ];
    }
}
