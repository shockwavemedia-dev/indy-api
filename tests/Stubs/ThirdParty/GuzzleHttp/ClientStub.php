<?php

declare(strict_types=1);

namespace Tests\Stubs\ThirdParty\GuzzleHttp;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tests\Stubs\AbstractStub;

/**
 * @coversNothing
 */
final class ClientStub extends AbstractStub implements ClientInterface
{
    /**
     * @throws \Throwable
     */
    public function send(RequestInterface $request, array $options = []): ResponseInterface
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function sendAsync(RequestInterface $request, array $options = []): PromiseInterface
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function request(string $method, $uri, array $options = []): ResponseInterface
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function requestAsync(string $method, $uri, array $options = []): PromiseInterface
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function getConfig(?string $option = null)
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
