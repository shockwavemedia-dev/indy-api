<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Throwable;

/**
 * Abstract class for all stubs. The responses are stored as method name as array key and
 * response for that method as array value.
 *
 * @coversNothing
 */
abstract class AbstractStub
{
    private array $calls;

    private array $responses;

    public function __construct(?array $responses = null)
    {
        $this->calls = [];
        $this->responses = $responses ?? [];
    }

    public function getCalls(?string $method = null, ?int $index = null): array
    {
        if (\is_string($method) === true) {
            return $this->calls[$index ?? 0][$method] ?? [];
        }

        return $this->calls;
    }

    /**
     * Fetch appropriate piped response for method call.
     *
     * @throws Throwable
     */
    protected function fetchPipedResponse(PipedResponseStub $response): array
    {
        $response = \array_shift($response->responses);

        if ($response instanceof Throwable === true) {
            throw $response;
        }

        return $response;
    }

    /**
     * Fetch appropriate response for method call.
     *
     * @throws Throwable
     */
    protected function fetchResponse(string $method): mixed
    {
        if ($this->hasResponse($method) === false) {
            return null;
        }

        $response = $this->responses[$method];

        if ($response instanceof Throwable === true) {
            throw $response;
        }

        /*
         * If stubbed method is called in multiple times within same service,
         * passing in an array as response can be used to return a different value
         * on each call to method.
         *
         * If we have PipedResponseStub, assume it is a stack of responses and shift the first
         * response to be returned.
         */
        if ($response instanceof PipedResponseStub === true) {
            return $this->fetchPipedResponse($response);
        }

        return $response;
    }

    /**
     * Check if stub has a response stubbed.
     */
    protected function hasResponse(string $method): bool
    {
        if (\array_key_exists($method, $this->responses) === false) {
            return false;
        }

        return true;
    }

    /**
     * Record call made.
     */
    protected function recordCall(string $method, array $parameters): void
    {
        $this->calls[] = [
            $method => $parameters,
        ];
    }
}
