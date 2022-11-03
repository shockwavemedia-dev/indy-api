<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Graphics;

use App\Http\Requests\BaseRequest;

final class CreateGraphicRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getAttachments(): array
    {
        return $this->file('attachments') ?? [];
    }

    public function getDescription(): ?string
    {
        return $this->getString('description');
    }

    public function getExtras(): array
    {
        return $this->getArray('extras');
    }

    public function getSubject(): string
    {
        return $this->getString('subject');
    }

    public function rules(): array
    {
        return [
            'subject' => 'required|string',
            'description' => 'json',
            'attachments' => 'required',
            'extras' => 'required|array',
            'extras.*' => [
                'required',
                'string',
            ]
        ];
    }
}
