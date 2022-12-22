<?php

declare(strict_types=1);

namespace App\Services\SocialMedia\Resolvers;

use App\Models\SocialMedia;
use App\Repositories\Interfaces\SocialMediaRepositoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaUpdateResolverInterface;
use Carbon\Carbon;

final class SocialMediaUpdateResolver implements SocialMediaUpdateResolverInterface
{
    private SocialMediaRepositoryInterface $socialMediaRepository;

    public function __construct(SocialMediaRepositoryInterface $socialMediaRepository)
    {
        $this->socialMediaRepository = $socialMediaRepository;
    }

    public function update(SocialMedia $socialMedia, array $changes): SocialMedia
    {
        $socialMediaArray = [
            'post' => $socialMedia->getPost(),
            'copy' => $socialMedia->getCopy(),
            'status' => $socialMedia->getStatus(),
            'notes' => $socialMedia->getNotes(),
            'post_date' => $socialMedia->getPostDate(),
        ];

        $newChannels = $changes['channels'];

        unset($changes['channels']);

        $updates = \array_diff($changes, $socialMediaArray);

        $updates = array_filter($updates);

        if (($updates['post_date'] ?? null) !== null) {
            $updates['post_date'] = new Carbon($updates['post_date']);
        }

        if (($updates['channels'] ?? null) !== null) {
            $updates['channels'] = $this->updateChannelsComplexity($socialMedia, $newChannels);
        }

        return $this->socialMediaRepository->update($socialMedia, $updates);
    }

    private function updateChannelsComplexity(SocialMedia $socialMedia, array $channels): ?array
    {
        if (count($socialMedia->getChannels() ?? []) === 0) {
            return $channels;
        }

        if (count($channels) === 0) {
            return [];
        }

        $newChannelsName = $channels;

        if (is_string($channels[0]) === false) {
            $newChannelsName = array_column($channels, 'name');
        }

        $updatedChannels = [];

        foreach ($channels as $channel) {
            $modifiedChannelFormat = [
                'name' => $channel['name'] ?? $channel,
                'quantity' => $channel['quantity'] ?? 0,
            ];

            $exist = false;

            foreach ($socialMedia->getChannels() as $existingChannel) {
                $oldChannel = $existingChannel['name'] ?? $existingChannel;

                // If it is not in the payload anymore remove
                if (in_array($oldChannel, $newChannelsName) === false) {
                    continue;
                }

                // Always get the quantity from the original, separate endpoint handle updating of quantity(cost)
                if ($modifiedChannelFormat['name'] === $oldChannel) {
                    $exist = true;

                    $modifiedChannelFormat['quantity'] = $existingChannel['quantity'] ?? 0;

                    $updatedChannels[] = $modifiedChannelFormat;
                }
            }

            if ($exist === false) {
                $updatedChannels[] = $modifiedChannelFormat;
            }
        }

        return $updatedChannels;
    }
}
