<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\LibraryCategories\Factories\LibraryCategoryFactory;
use App\Services\LibraryCategories\Interfaces\LibraryCategoryFactoryInterface;
use Illuminate\Support\ServiceProvider;

final class LibraryCategoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LibraryCategoryFactoryInterface::class, LibraryCategoryFactory::class);
    }
}
