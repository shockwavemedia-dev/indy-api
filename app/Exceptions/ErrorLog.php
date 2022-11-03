<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Jobs\ErrorLogs\ErrorLogJob;
use Sentry\Severity;
use Throwable;

final class ErrorLog implements ErrorLogInterface
{
    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function log(string $message, ?Severity $level = null)
    {
        $level = $level ?? new Severity(Severity::INFO);

        if ($level !== Severity::info()) {
//            \Sentry\captureMessage($message, $level);

            ErrorLogJob::dispatch(
                $message,
                $message,
                $level,
            );
        }
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function reportError(Throwable $throwable)
    {
        ErrorLogJob::dispatch(
            $throwable->getTraceAsString(),
            $throwable->getMessage(),
            Severity::ERROR,
        );
    }
}
