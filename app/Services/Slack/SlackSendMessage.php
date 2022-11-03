<?php

declare(strict_types=1);

namespace App\Services\Slack;

use App\Services\Slack\Exceptions\SlackSendMessageException;
use App\Services\Slack\Interfaces\SlackSendMessageInterface;
use App\Services\Slack\Resources\SlackUserResource;
use Vluzrmos\SlackApi\Contracts\SlackChat;

final class SlackSendMessage implements SlackSendMessageInterface
{
    private SlackChat $slackChat;

    public function __construct(SlackChat $slackChat)
    {
        $this->slackChat = $slackChat;
    }

    /**
     * @throws \App\Services\Slack\Exceptions\SlackSendMessageException
     */
    public function sendMessage(
        SlackUserResource $resource,
        string $message,
        ?array $options = []
    ): void {
        $response = $this->slackChat->message($resource->getSlackId(), $message, $options);

        if ($response->ok === false) {
            throw new SlackSendMessageException($response->error);
        }
    }
}
