<?php

declare(strict_types=1);

namespace App\Http\Resources\API\SocialMedia;

use App\Http\Resources\Resource;

final class CommentsResource extends Resource
{
    protected function getResponse(): array
    {
        $result = [];

        foreach ($this->resource as $comment) {
            $result[] = new CommentResource($comment);
        }

        return $result;
    }
}
