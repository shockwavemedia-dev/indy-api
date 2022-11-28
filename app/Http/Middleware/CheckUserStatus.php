<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enum\UserStatusEnum;
use Closure;
use Exception;
use Illuminate\Http\Request;

final class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        try {
            /** @var \App\Models\User $user */
            $user = auth()->user();

            if ($user->getStatus()->getValue() !== UserStatusEnum::ACTIVE) {
                return response()->json(['status' => 'You record is not active'], 403);
            }

            return $next($request);
        } catch (Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }
}
