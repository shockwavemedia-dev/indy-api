<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Departments\CreateDepartmentService;
use App\Services\Departments\DepartmentTicketNotificationHandler;
use App\Services\Departments\Interfaces\CreateDepartmentServiceInterface;
use App\Services\Departments\Interfaces\DepartmentTicketNotificationHandlerInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class DepartmentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            CreateDepartmentServiceInterface::class => CreateDepartmentService::class,
            DepartmentTicketNotificationHandlerInterface::class => DepartmentTicketNotificationHandler::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
