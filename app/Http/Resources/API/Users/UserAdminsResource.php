<?php

declare(strict_types=1);

namespace App\Http\Resources\API\Users;

use App\Http\Resources\Resource;

final class UserAdminsResource extends Resource
{
    protected function getResponse(): array
    {
        $users = [];

        foreach ($this->resource as $user) {
            $users['data'][] = new UserResource($user);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $users['page'] = $this->paginationResource($this->resource);

        return $users;
    }
}
