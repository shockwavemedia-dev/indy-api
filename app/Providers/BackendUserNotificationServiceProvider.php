<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\BackendUserNotifications\BackendUserNotificationResolverFactory;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverFactoryInterface;
use App\Services\BackendUserNotifications\Interfaces\BackendUserNotificationResolverInterface;
use App\Services\BackendUserNotifications\NotificationResolvers\FileApprovedNotificationResolver;
use App\Services\BackendUserNotifications\NotificationResolvers\FileFeedbackNotificationResolver;
use App\Services\BackendUserNotifications\NotificationResolvers\SupportRequestNotificationResolver;
use App\Services\BackendUserNotifications\NotificationResolvers\TicketAssignedNotificationResolver;
use App\Services\BackendUserNotifications\NotificationResolvers\TicketNoteNotificationResolver;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class BackendUserNotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag(
            [
                FileApprovedNotificationResolver::class,
                FileFeedbackNotificationResolver::class,
                TicketAssignedNotificationResolver::class,
                TicketNoteNotificationResolver::class,
                SupportRequestNotificationResolver::class,

            ],
            BackendUserNotificationResolverInterface::class
        );

        $this->app->bind(BackendUserNotificationResolverFactoryInterface::class,
            static function (Application $app) {
                return new BackendUserNotificationResolverFactory(
                    $app->tagged(BackendUserNotificationResolverInterface::class)
                );
            }
        );
    }
}
