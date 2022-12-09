<?php

declare(strict_types=1);

namespace App\Http\Requests\API\SocialMedia;

use App\Http\Requests\BaseRequest;

final class UpdateSocialMediaBoostRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getExtras(): array
    {
        return $this->getArray('extras');
    }

    public function rules(): array
    {
        return [
            'extras' => 'array|required',
        ];
    }
}
