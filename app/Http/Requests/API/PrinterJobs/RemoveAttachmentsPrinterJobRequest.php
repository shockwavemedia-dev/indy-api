<?php

declare(strict_types=1);

namespace App\Http\Requests\API\PrinterJobs;

use App\Http\Requests\BaseRequest;

final class RemoveAttachmentsPrinterJobRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getAttachmentIds(): ?array
    {
        return $this->getArray('attachment_ids');
    }

    public function rules(): array
    {
        return [
            'attachment_ids' => 'array',
        ];
    }
}

