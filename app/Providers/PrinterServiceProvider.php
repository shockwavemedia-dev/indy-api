<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Printers\Factories\PrinterFactory;
use App\Services\Printers\Interfaces\PrinterFactoryInterface;
use Illuminate\Support\ServiceProvider;

final class PrinterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            PrinterFactoryInterface::class => PrinterFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
