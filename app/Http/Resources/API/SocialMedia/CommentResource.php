<?php

declare(strict_types=1);

namespace App\Http\Resources\API\SocialMedia;

use App\Http\Resources\Resource;
use App\Models\SocialMediaComment;

final class CommentResource extends Resource
{
    protected function getResponse(): array
    {
        /** @var SocialMediaComment $comment */
        $comment = $this->resource;

        return [
            'id' => $comment->getId(),
            'comment' => $comment->getComment(),
            'created_by' => $comment->getCreatedBy()->getFullName(),
            'created_by_id' => $comment->getCreatedBy()->getId(),
            'created_at' => $comment->getCreatedAt(),
        ];
    }
}
