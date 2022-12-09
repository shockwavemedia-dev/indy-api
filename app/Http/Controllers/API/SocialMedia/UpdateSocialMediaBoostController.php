<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\SocialMedia;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\SocialMedia\UpdateSocialMediaBoostRequest;
use App\Http\Resources\API\SocialMedia\SocialMediaResource;
use App\Models\SocialMedia;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdateSocialMediaBoostController extends AbstractAPIController
{
    public function __construct(
        private SocialMediaRepositoryInterface $socialMediaRepository,
    ) {
    }

    public function __invoke(UpdateSocialMediaBoostRequest $request, int $id): JsonResource
    {
        /** @var SocialMedia $socialMedia */
        $socialMedia = $this->socialMediaRepository->find($id);

        if ($socialMedia === null) {
            return $this->respondNotFound([
                'message' => 'Social Media not found',
            ]);
        }

        $existingChannels = $socialMedia->getChannels();

        foreach ($existingChannels as $index => $existingChannel) {
            foreach ($request->getExtras() as $extra) {
                if ($extra['name'] !== $existingChannel['name']) {
                    continue;
                }

                $existingChannels[$index] = $extra;
            }
        }

        // @TODO add checking if there is any changes
        $socialMedia->setAttribute('channels', $existingChannels);
        $socialMedia->save();

        return new SocialMediaResource($socialMedia);
    }
}
