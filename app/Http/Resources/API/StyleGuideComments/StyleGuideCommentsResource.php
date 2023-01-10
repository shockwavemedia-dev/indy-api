<?php

declare(strict_types=1);

namespace App\Http\Resources\API\StyleGuideComments;

use App\Http\Resources\Resource;

final class StyleGuideCommentsResource extends Resource
{
    protected function getResponse(): array
    {
        $resources = [];

        foreach ($this->resource as $styleGuide) {
            $resources['data'][] = new StyleGuideCommentResource($styleGuide);
        }

        if (count($this->resource) === 0) {
            self::$wrap = null;
        }

        return $resources;
    }
}
