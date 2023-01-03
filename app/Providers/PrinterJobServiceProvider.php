<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\PrinterJobs\Factories\PrinterJobAttachmentFactory;
use App\Services\PrinterJobs\Factories\PrinterJobFactory;
use App\Services\PrinterJobs\Interfaces\PrinterJobAttachmentFactoryInterface;
use App\Services\PrinterJobs\Interfaces\PrinterJobFactoryInterface;
use App\Services\PrinterJobs\Interfaces\UpdatePrinterJobResolverInterface;
use App\Services\PrinterJobs\Resolvers\UpdatePrinterJobResolver;
use Illuminate\Support\ServiceProvider;

final class PrinterJobServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            PrinterJobFactoryInterface::class => PrinterJobFactory::class,
            UpdatePrinterJobResolverInterface::class => UpdatePrinterJobResolver::class,
            PrinterJobAttachmentFactoryInterface::class => PrinterJobAttachmentFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
