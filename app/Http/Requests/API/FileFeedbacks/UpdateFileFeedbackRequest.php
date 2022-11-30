<?php

namespace App\Http\Requests\API\FileFeedbacks;

use App\Http\Requests\BaseRequest;

final class UpdateFileFeedbackRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getFeedback(): string
    {
        return $this->getString('feedback');
    }

    public function getAttachments(): array
    {
        return $this->file('attachment') ?? [];
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'feedback' => 'string|required',
        ];
    }
}
