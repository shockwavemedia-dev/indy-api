<?php

declare(strict_types=1);

namespace Tests\Stubs\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

/**
 * Must only be used in TESTS
 *
 * @coversNothing
 */
final class FakeAuthMiddleware
{
    private User $user;

    /**
     * FakeAuthMiddleware constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * This middleware does nothing, it's useful for
     * replacing other middleware in tests
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->permissionService->loginOnce($this->user);

        return $next($request);
    }
}
