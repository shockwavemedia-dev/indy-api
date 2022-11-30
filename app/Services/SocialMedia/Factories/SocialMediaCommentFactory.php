<?php

declare(strict_types=1);

namespace App\Services\SocialMedia\Factories;

use App\Models\SocialMediaComment;
use App\Repositories\Interfaces\SocialMediaCommentRepositoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaCommentFactoryInterface;
use App\Services\SocialMedia\Resources\CreateCommentResource;

final class SocialMediaCommentFactory implements SocialMediaCommentFactoryInterface
{
    private SocialMediaCommentRepositoryInterface $socialMediaCommentRepository;

    public function __construct(SocialMediaCommentRepositoryInterface $socialMediaCommentRepository)
    {
        $this->socialMediaCommentRepository = $socialMediaCommentRepository;
    }

    public function make(CreateCommentResource $resource): SocialMediaComment
    {
        /** @var SocialMediaComment $comment */
        $comment = $this->socialMediaCommentRepository->create([
            'social_media_id' => $resource->getSocialMedia()->getId(),
            'comment' => $resource->getComment(),
            'created_by' => $resource->getCreatedBy()->getId(),
        ]);

        return $comment;
    }
}
