<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\SupportRequests\Interfaces\SupportRequestFactoryInterface;
use App\Services\SupportRequests\SupportRequestFactory;
use Illuminate\Support\ServiceProvider;

final class SupportRequestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            SupportRequestFactoryInterface::class => SupportRequestFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
