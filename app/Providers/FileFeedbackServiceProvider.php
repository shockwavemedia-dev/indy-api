<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\FileFeedbacks\FileFeedbackCreationService;
use App\Services\FileFeedbacks\Interfaces\FileFeedbackCreationServiceInterface;
use Illuminate\Support\ServiceProvider;

final class FileFeedbackServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FileFeedbackCreationServiceInterface::class, FileFeedbackCreationService::class);
    }
}
