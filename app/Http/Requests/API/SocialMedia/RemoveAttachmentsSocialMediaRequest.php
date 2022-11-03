<?php

declare(strict_types=1);

namespace App\Http\Requests\API\SocialMedia;

use App\Enum\SocialMediaStatusesEnum;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

final class RemoveAttachmentsSocialMediaRequest extends BaseRequest
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

