<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\SocialMedia\SocialMediaResource;
use App\Models\SocialMediaComment;
use App\Repositories\Interfaces\SocialMediaCommentRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeleteSocialMediaCommentController extends AbstractAPIController
{
    private SocialMediaCommentRepositoryInterface $socialMediaCommentRepository;

    public function __construct(
        SocialMediaCommentRepositoryInterface $socialMediaCommentRepository
    ) {
        $this->socialMediaCommentRepository = $socialMediaCommentRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var SocialMediaComment $socialMediaComment */
        $socialMediaComment = $this->socialMediaCommentRepository->find($id);

        if ($socialMediaComment === null) {
            return $this->respondNotFound([
                'message' => 'Comment not found',
            ]);
        }

        if ($this->getUser()->getId() !== $socialMediaComment->getCreatedById()) {
            return $this->respondForbidden([
                'message' => 'User not allowed to access this.',
            ]);
        }

        $socialMediaComment->delete();
        $socialMediaComment->save();

        return new SocialMediaResource($socialMediaComment->getSocialMedia());
    }
}
