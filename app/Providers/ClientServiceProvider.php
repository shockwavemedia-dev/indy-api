<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\ClientUserNotifications\ClientNotificationResolverFactory;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverFactoryInterface;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverInterface;
use App\Services\ClientUserNotifications\NotificationResolvers\FileFeedbackNotificationResolver;
use App\Services\ClientUserNotifications\NotificationResolvers\TicketAssigneeStatusNotificationResolver;
use App\Services\ClientUserNotifications\NotificationResolvers\TicketEmailNotificationResolver;
use App\Services\ClientUserNotifications\NotificationResolvers\TicketFileUploadNotificationResolver;
use App\Services\ClientUserNotifications\NotificationResolvers\TicketNoteNotificationResolver;
use App\Services\Clients\ClientCreationService;
use App\Services\Clients\Interfaces\ClientCreationServiceInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class ClientServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ClientCreationServiceInterface::class, ClientCreationService::class);

        $this->app->tag(
            [
                FileFeedbackNotificationResolver::class,
                TicketAssigneeStatusNotificationResolver::class,
                TicketEmailNotificationResolver::class,
                TicketFileUploadNotificationResolver::class,
                TicketNoteNotificationResolver::class,
            ],
            ClientNotificationResolverInterface::class
        );

        $this->app->bind(ClientNotificationResolverFactoryInterface::class,
            static function (Application $app) {
                return new ClientNotificationResolverFactory($app->tagged(ClientNotificationResolverInterface::class));
            }
        );
    }
}
