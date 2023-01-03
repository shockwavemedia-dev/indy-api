<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Folders\FolderFactory;
use App\Services\Folders\Interfaces\FolderFactoryInterface;
use App\Services\Folders\Interfaces\FolderNameResolverInterface;
use App\Services\Folders\Interfaces\FolderSortResolverInterface;
use App\Services\Folders\Interfaces\UploadFileFolderResolverInterface;
use App\Services\Folders\Resolvers\FolderNameResolver;
use App\Services\Folders\Resolvers\FolderSortResolver;
use App\Services\Folders\Resolvers\UploadFileFolderResolver;
use Illuminate\Support\ServiceProvider;

final class FolderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            FolderFactoryInterface::class => FolderFactory::class,
            FolderNameResolverInterface::class => FolderNameResolver::class,
            FolderSortResolverInterface::class => FolderSortResolver::class,
            UploadFileFolderResolverInterface::class => UploadFileFolderResolver::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
