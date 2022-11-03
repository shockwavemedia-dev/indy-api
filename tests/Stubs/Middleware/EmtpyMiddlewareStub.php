<?php

declare(strict_types=1);

namespace Tests\Stubs\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * @coversNothing
 */
final class EmtpyMiddlewareStub
{
    /**
     * This middleware does nothing, it's useful
     * for replacing other middleware in tests
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
