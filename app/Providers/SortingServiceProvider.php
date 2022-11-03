<?php

namespace App\Providers;

use App\Services\Sorting\Interfaces\SortByYearAndMonthResolverInterface;
use App\Services\Sorting\SortByYearAndMonthResolver;
use Illuminate\Support\ServiceProvider;

class SortingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SortByYearAndMonthResolverInterface::class, SortByYearAndMonthResolver::class);
    }
}
