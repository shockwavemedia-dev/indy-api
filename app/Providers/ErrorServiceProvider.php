<?php

declare(strict_types=1);

namespace App\Providers;

use App\Exceptions\ErrorLog;
use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Services\ErrorLogs\ErrorLogFactory;
use App\Services\ErrorLogs\Interfaces\ErrorLogFactoryInterface;
use Illuminate\Support\ServiceProvider;

final class ErrorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            ErrorLogInterface::class => ErrorLog::class,
            ErrorLogFactoryInterface::class => ErrorLogFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
