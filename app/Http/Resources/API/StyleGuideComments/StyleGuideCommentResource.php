<?php

declare(strict_types=1);

namespace App\Http\Resources\API\StyleGuideComments;

use App\Http\Resources\Resource;
use App\Models\StyleGuideComment;

final class StyleGuideCommentResource extends Resource
{
    public static $wrap = null;

    protected function getResponse(): array
    {
        /** @var StyleGuideComment $styleGuideComment */
        $styleGuideComment = $this->resource;

        return [
            'id' => $styleGuideComment->getId(),
            'user' => $styleGuideComment->getUser(),
            'ticket_id' => $styleGuideComment->getTicket()->getId(),
            'message' => $styleGuideComment->getMessage(),
            'created_at' => $styleGuideComment->getCreatedAtAsString(),
        ];
    }
}
