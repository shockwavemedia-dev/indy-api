<?php

declare(strict_types=1);

namespace App\Services\Slack\Resolvers;

use App\Models\User;
use App\Services\Slack\Exceptions\SlackUserNullException;
use App\Services\Slack\Interfaces\SlackUserResolverInterface;
use App\Services\Slack\Resources\SlackUserResource;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Vluzrmos\SlackApi\Contracts\SlackUser;

final class SlackUserResolver implements SlackUserResolverInterface
{
    private SlackUser $slackUser;

    public function __construct(SlackUser $slackUser)
    {
        $this->slackUser = $slackUser;
    }

    /**
     * @throws SlackUserNullException
     * @throws UnknownProperties
     */
    public function findSlackUser(User $user): SlackUserResource
    {
        $response = $this->slackUser->lookupByEmail($user->getEmail());

        if ($response->ok === false) {
            throw new SlackUserNullException('Email provided does not have slack user.');
        }

        return new SlackUserResource([
            'slackId' => $response->user->id,
            'name' => $response->user->profile->display_name,
        ]);
    }
}
