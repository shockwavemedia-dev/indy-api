<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Folders;

use App\Http\Requests\BaseRequest;

final class UploadFileFolderRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function getFiles(): array
    {
        return $this->file('files');
    }

    public function rules(): array
    {
        return [
            'files' => 'required',
        ];
    }
}
