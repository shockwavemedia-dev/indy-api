<?php

namespace App\Services\StyleGuideComments;

use App\Models\StyleGuideComment;
use App\Repositories\Interfaces\StyleGuideCommentRepositoryInterface;
use App\Services\StyleGuideComments\Interfaces\StyleGuideCommentFactoryInterface;
use App\Services\StyleGuideComments\Resources\CreateStyleGuideCommentResource;

final class StyleGuideCommentFactory implements StyleGuideCommentFactoryInterface
{
    public function __construct(public StyleGuideCommentRepositoryInterface $styleGuideCommentRepository)
    {
    }

    public function make(CreateStyleGuideCommentResource $resource): StyleGuideComment
    {
        /** @var StyleGuideComment $styleGuideComment */
        $styleGuideComment = $this->styleGuideCommentRepository->create([
            'ticket_id' => $resource->getTicket()->getId(),
            'user_id' => $resource->getUser()->getId(),
            'message' => $resource->getMessage(),
        ]);

        return $styleGuideComment;
    }
}
