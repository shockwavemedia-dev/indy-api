<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Notifications\Interfaces\NotificationFactoryInterface;
use App\Services\Notifications\Interfaces\NotificationUserFactoryInterface;
use App\Services\Notifications\NotificationFactory;
use App\Services\Notifications\NotificationUserFactory;
use Illuminate\Support\ServiceProvider;

final class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            NotificationFactoryInterface::class => NotificationFactory::class,
            NotificationUserFactoryInterface::class => NotificationUserFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
