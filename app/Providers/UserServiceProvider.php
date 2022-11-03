<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Users\CheckUserPermission;
use App\Services\Users\Factories\LeadClientFactory;
use App\Services\Users\Interfaces\CheckUserPermissionInterface;
use App\Services\Users\Interfaces\UserEmailVerificationResolverInterface;
use App\Services\Users\Interfaces\UserPermissionConfigResolverInterface;
use App\Services\Users\Interfaces\UserResetPasswordResolverInterface;
use App\Services\Users\Resolvers\UserEmailVerificationResolver;
use App\Services\Users\Resolvers\UserResetPasswordResolver;
use App\Services\Users\UserClientCreationService;
use App\Services\Users\UserCreationService;
use App\Services\Users\UserPermissionConfigResolver;
use Illuminate\Foundation\Application;
use App\Services\Users\Interfaces\UserCreationServiceInterface;
use App\Services\Users\Interfaces\UserTypeFactoryInterface;
use App\Services\Users\Interfaces\UserTypeFactoryResolverInterface;
use App\Services\Users\UserAdminCreationService;
use App\Services\Users\UserTypeFactoryResolver;
use Illuminate\Support\ServiceProvider;

final class UserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            CheckUserPermissionInterface::class => CheckUserPermission::class,
            UserCreationServiceInterface::class => UserCreationService::class,
            UserEmailVerificationResolverInterface::class => UserEmailVerificationResolver::class,
            UserPermissionConfigResolverInterface::class => UserPermissionConfigResolver::class,
            UserResetPasswordResolverInterface::class => UserResetPasswordResolver::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        $this->app->tag(
            [
                LeadClientFactory::class,
                UserAdminCreationService::class,
                UserClientCreationService::class,
            ],
            UserTypeFactoryInterface::class
        );

        $this->app->bind(UserTypeFactoryResolverInterface::class,
            static function (Application $app) {
                return new UserTypeFactoryResolver($app->tagged(UserTypeFactoryInterface::class));
            }
        );
    }
}
