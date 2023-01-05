<?php

declare(strict_types=1);

namespace App\Http\Requests\API\StyleGuideComments;

use App\Http\Requests\BaseRequest;

final class CreateStyleGuideCommentRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getMessage(): string
    {
        return $this->getString('message');
    }

    public function rules(): array
    {
        return [
            'message' => 'required|string',
        ];
    }
}
