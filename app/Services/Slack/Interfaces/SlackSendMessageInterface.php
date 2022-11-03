<?php

declare(strict_types=1);

namespace App\Services\Slack\Interfaces;

use App\Services\Slack\Exceptions\SlackSendMessageException;
use App\Services\Slack\Resources\SlackUserResource;

interface SlackSendMessageInterface
{
    /**
     * @throws SlackSendMessageException
     */
    public function sendMessage(
        SlackUserResource $resource,
        string $message,
        ?array $options = []
    ): void;
}
