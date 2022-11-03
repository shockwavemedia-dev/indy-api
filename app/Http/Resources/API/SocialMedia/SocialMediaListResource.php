<?php

declare(strict_types=1);

namespace App\Http\Resources\API\SocialMedia;

use App\Http\Resources\Resource;

final class SocialMediaListResource extends Resource
{
    protected function getResponse(): array
    {
        $result = [];

        foreach ($this->resource as $socialMedia) {
            $result['data'][] = new SocialMediaResource($socialMedia);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        $result['page'] = $this->paginationResource($this->resource);

        return $result;
    }
}
