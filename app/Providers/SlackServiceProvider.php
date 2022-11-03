<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Slack\Interfaces\SlackSendMessageInterface;
use App\Services\Slack\Interfaces\SlackUserResolverInterface;
use App\Services\Slack\Resolvers\SlackUserResolver;
use App\Services\Slack\SlackSendMessage;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class SlackServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            SlackSendMessageInterface::class => SlackSendMessage::class,
            SlackUserResolverInterface::class => SlackUserResolver::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
