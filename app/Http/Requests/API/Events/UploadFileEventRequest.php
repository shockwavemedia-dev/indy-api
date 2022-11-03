<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Events;

use App\Http\Requests\BaseRequest;

final class UploadFileEventRequest extends BaseRequest
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
