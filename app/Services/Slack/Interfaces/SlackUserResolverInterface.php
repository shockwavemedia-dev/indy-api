<?php

declare(strict_types=1);

namespace App\Services\Slack\Interfaces;

use App\Models\User;
use App\Services\Slack\Exceptions\SlackUserNullException;
use App\Services\Slack\Resources\SlackUserResource;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

interface SlackUserResolverInterface
{
    /**
     * @throws SlackUserNullException
     * @throws UnknownProperties
     */
    public function findSlackUser(User $user): SlackUserResource;
}
