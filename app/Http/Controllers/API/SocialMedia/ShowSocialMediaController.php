<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\SocialMedia\SocialMediaResource;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowSocialMediaController extends AbstractAPIController
{
    private SocialMediaRepositoryInterface $socialMediaRepository;

    public function __construct(SocialMediaRepositoryInterface $socialMediaRepository)
    {
        $this->socialMediaRepository = $socialMediaRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $socialMedia = $this->socialMediaRepository->find($id);

        if ($socialMedia === null) {
            return $this->respondNotFound([
                'message' => 'Social Media not found',
            ]);
        }

        return new SocialMediaResource($socialMedia);
    }
}
