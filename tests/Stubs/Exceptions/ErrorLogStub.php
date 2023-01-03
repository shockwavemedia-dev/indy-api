<?php

declare(strict_types=1);

namespace Tests\Stubs\Exceptions;

use App\Exceptions\Interfaces\ErrorLogInterface;
use Sentry\Severity;
use Tests\Stubs\AbstractStub;
use Throwable;

/**
 * @coversNothing
 */
final class ErrorLogStub extends AbstractStub implements ErrorLogInterface
{
    /**
     * @throws \Throwable
     */
    public function log(string $message, ?Severity $level = null)
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }

    /**
     * @throws \Throwable
     */
    public function reportError(Throwable $throwable)
    {
        $this->recordCall(__FUNCTION__, \func_get_args());

        return $this->fetchResponse(__FUNCTION__);
    }
}
