<?php

declare(strict_types=1);

namespace App\Http\Requests\API\SocialMedia;

use App\Http\Requests\BaseRequest;

final class CreateSocialMediaCommentRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getComment(): string
    {
        return $this->getString('comment');
    }

    public function getTaggedUsers(): ?array
    {
        return $this->get('users_tagged');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'comment' => 'required|string',
            'users_tagged' => 'array|nullable',
        ];
    }
}
