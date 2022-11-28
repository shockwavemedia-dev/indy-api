<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enum\AdminRoleEnum;
use App\Enum\ClientRoleEnum;
use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\Printer;
use App\Models\Users\AdminUser;
use App\Models\Users\ClientUser;
use App\Services\Users\Interfaces\CheckUserPermissionInterface;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Sentry\Severity;

final class CheckPermission
{
    private CheckUserPermissionInterface $checkUserPermission;

    private ErrorLogInterface $sentryHandler;

    public function __construct(
        CheckUserPermissionInterface $checkUserPermission,
        ErrorLogInterface $sentryHandler
    ) {
        $this->checkUserPermission = $checkUserPermission;
        $this->sentryHandler = $sentryHandler;
    }

    public function handle(Request $request, Closure $next, string $module, string $permission)
    {
        try {
            /** @var \App\Models\User $user */
            $user = auth()->user();

            $userType = $user->getUserType();

            $userTypeEnum = null;

            if ($userType instanceof AdminUser === true) {
                $userTypeEnum = new AdminRoleEnum($userType->getRole());
            }

            if ($userType instanceof ClientUser === true) {
                $userTypeEnum = new ClientRoleEnum($userType->getRole());
            }

            if ($userType instanceof Printer === true) {
                $userTypeEnum = new AdminRoleEnum(AdminRoleEnum::PRINT_MANAGER);
            }

            $hasPermission = $this->checkUserPermission->hasPermission($userTypeEnum, $module, $permission);

            if ($hasPermission === false) {
                $this->sentryHandler->log(
                    \sprintf(
                        '%s has no access to this %s module and %s action',
                        $userTypeEnum->getValue(),
                        $module,
                        $permission
                    ),
                    Severity::info()
                );

                return response()->json(['status' => 'User has no permission for this module'], 403);
            }

            return $next($request);
        } catch (Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }
}
