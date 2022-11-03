<?php

declare(strict_types=1);

namespace App\Services\Slack\Resources;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @codeCoverageIgnore
 */
final class SlackUserResource extends DataTransferObject
{
    public string $slackId;

    public string $name;

    public function getSlackId(): string
    {
        return $this->slackId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setSlackId(string $slackId): self
    {
        $this->slackId = $slackId;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

}
