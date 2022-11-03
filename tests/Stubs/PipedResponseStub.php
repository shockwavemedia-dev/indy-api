<?php

declare(strict_types=1);

namespace Tests\Stubs;

/**
 * Used to pipe responses for AbstractStub to push out
 * for multiple calls to same method.
 *
 * @coversNothing
 */
final class PipedResponseStub
{
    public array $responses;

    public function __construct(array $responses)
    {
        $this->responses = $responses;
    }
}
