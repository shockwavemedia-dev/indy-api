<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\TicketEmails\AssigneeTicketEmailSender;
use App\Services\TicketEmails\ClientTicketEmailSender;
use App\Services\TicketEmails\Interfaces\TicketEmailSenderFactoryInterface;
use App\Services\TicketEmails\Interfaces\TicketEmailSenderInterface;
use App\Services\TicketEmails\TicketEmailFactory;
use App\Services\TicketEmails\Interfaces\TicketEmailFactoryInterface;
use App\Services\TicketEmails\TicketEmailSenderFactory;
use App\Services\Users\Interfaces\UserTypeFactoryInterface;
use App\Services\Users\Interfaces\UserTypeFactoryResolverInterface;
use App\Services\Users\UserTypeFactoryResolver;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class TicketEmailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            TicketEmailFactoryInterface::class => TicketEmailFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        $this->app->tag(
            [
                ClientTicketEmailSender::class,
                AssigneeTicketEmailSender::class,
            ],
            TicketEmailSenderInterface::class
        );

        $this->app->bind(TicketEmailSenderFactoryInterface::class,
            static function (Application $app) {
                return new TicketEmailSenderFactory($app->tagged(TicketEmailSenderInterface::class));
            }
        );
    }
}
