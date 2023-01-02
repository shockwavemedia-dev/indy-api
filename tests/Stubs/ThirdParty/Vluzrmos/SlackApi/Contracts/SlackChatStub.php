<?php

declare(strict_types=1);

namespace Tests\Stubs\ThirdParty\Vluzrmos\SlackApi\Contracts;

use Tests\Stubs\AbstractStub;
use Vluzrmos\SlackApi\Contracts\SlackChat;

/**
 * @coversNothing
 */
final class SlackChatStub extends AbstractStub implements SlackChat
{
    /**
     * @throws \Throwable
     */
    public function delete($channel, $ts)
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function message($channel, $text, $options = [])
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function postMessage($channel, $text, $options = [])
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function update($channel, $text, $ts)
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
