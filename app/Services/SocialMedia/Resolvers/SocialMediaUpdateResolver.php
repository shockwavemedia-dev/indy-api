<?php

declare(strict_types=1);

namespace App\Services\SocialMedia\Resolvers;

use App\Models\SocialMedia;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaUpdateResolverInterface;
use Carbon\Carbon;
use Illuminate\Support\Arr;

final class SocialMediaUpdateResolver implements SocialMediaUpdateResolverInterface
{
    private SocialMediaRepositoryInterface $socialMediaRepository;

    public function __construct(SocialMediaRepositoryInterface $socialMediaRepository) {
        $this->socialMediaRepository = $socialMediaRepository;
    }

    public function update(SocialMedia $socialMedia, array $changes): SocialMedia
    {
        $socialMediaArray = [
            'post' => $socialMedia->getPost(),
            'copy' => $socialMedia->getCopy(),
            'status' => $socialMedia->getStatus(),
            'channels' => implode(',', $socialMedia->getChannels()),
            'notes' => $socialMedia->getNotes(),
            'post_date' => $socialMedia->getPostDate(),
        ];

        if (Arr::get($changes, 'channels') !== null) {
            $changes['channels'] = implode(',', $changes['channels']);
        }

        $updates = \array_diff($changes, $socialMediaArray);

        if (Arr::get($updates, 'channels') !== null) {
            $updates['channels'] = explode(',', $updates['channels']);
        }

        $updates = array_filter($updates);

        if ($updates['post_date'] !== null) {
            $updates['post_date'] = new Carbon($updates['post_date']);
        }

        return $this->socialMediaRepository->update($socialMedia, $updates);
    }
}
