<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Screens\Factories\ScreenFactory;
use App\Services\Screens\Interfaces\ScreenFactoryInterface;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class ScreenServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            ScreenFactoryInterface::class => ScreenFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
