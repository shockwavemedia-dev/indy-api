<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Authentication;

use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\API\Users\UserResource;
use App\Http\Resources\Resource;
use Illuminate\Support\Arr;

final class UserAccessTokenResource extends Resource
{
    public static $wrap = null;

    /**
     * @return mixed[]
     *
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        $response = $this->resource;

        $result = [
            'token_type' => Arr::get($response, 'token_type'),
            'expires_in' => Arr::get($response, 'expires_in', 0),
            'access_token' => Arr::get($response, 'access_token'),
            'refresh_token' => Arr::get($response, 'refresh_token'),
        ];

        $user = Arr::get($response, 'user', null);

        if ($user !== null) {
            $result['user'] = new UserResource($user);
        }

        return $result;
    }
}
