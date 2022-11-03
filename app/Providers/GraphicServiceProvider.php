<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Graphics\Factories\GraphicRequestFactory;
use App\Services\Graphics\Interfaces\Factories\GraphicRequestFactoryInterface;
use Illuminate\Support\ServiceProvider;

final class GraphicServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            GraphicRequestFactoryInterface::class => GraphicRequestFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
