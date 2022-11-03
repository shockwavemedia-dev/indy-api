<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\EmailLogs\EmailLogFactory;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use Illuminate\Support\ServiceProvider;

final class EmailLogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(EmailLogFactoryInterface::class, EmailLogFactory::class);
    }
}
