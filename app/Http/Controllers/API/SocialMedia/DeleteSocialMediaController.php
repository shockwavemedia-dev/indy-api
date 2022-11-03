<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Models\SocialMedia;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeleteSocialMediaController extends AbstractAPIController
{
    private SocialMediaRepositoryInterface $socialMediaRepository;

    public function __construct(SocialMediaRepositoryInterface $socialMediaRepository) {
        $this->socialMediaRepository = $socialMediaRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var SocialMedia $socialMedia */
        $socialMedia = $this->socialMediaRepository->find($id);

        if($socialMedia === null) {
            return $this->respondNoContent();
        }

        if (
            $this->getUser()->getUserType()->getType()->getValue() !== UserTypeEnum::ADMIN &&
            $socialMedia->getClient()->getId() !== $this->getUser()->getUserType()->getClient()->getId()
        ) {
            return $this->respondNoContent();
        }

        $socialMedia->delete();

        return $this->respondNoContent();
    }
}
