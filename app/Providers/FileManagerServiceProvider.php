<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\FileManager\Drivers\GoogleCloudStorageUploadManager;
use App\Services\FileManager\Drivers\LocalStorageUploadManager;
use App\Services\FileManager\Drivers\S3FileRemoverManager;
use App\Services\FileManager\Drivers\S3FileUploadManager;
use App\Services\FileManager\Factories\BucketFactory;
use App\Services\FileManager\Factories\FileRemoverDriverFactory;
use App\Services\FileManager\Factories\FileUploadDriverFactory;
use App\Services\FileManager\Factories\S3ClientFactory;
use App\Services\FileManager\Factories\StorageClientFactory;
use App\Services\FileManager\FileRemover;
use App\Services\FileManager\FileUploader;
use App\Services\FileManager\Interfaces\BucketFactoryInterface;
use App\Services\FileManager\Interfaces\BucketResolverInterface;
use App\Services\FileManager\Interfaces\FileManagerConfigResolverInterface;
use App\Services\FileManager\Interfaces\FileRemoverDriverFactoryInterface;
use App\Services\FileManager\Interfaces\FileRemoverInterface;
use App\Services\FileManager\Interfaces\FileRemoverManagerResolverInterface;
use App\Services\FileManager\Interfaces\FileUploadDriverFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploaderInterface;
use App\Services\FileManager\Interfaces\FileUploadManagerResolverInterface;
use App\Services\FileManager\Interfaces\GoogleCloudConfigResolverInterface;
use App\Services\FileManager\Interfaces\S3ClientFactoryInterface;
use App\Services\FileManager\Interfaces\S3SignedUrlServiceInterface;
use App\Services\FileManager\Interfaces\StorageClientFactoryInterface;
use App\Services\FileManager\Resolvers\BucketResolver;
use App\Services\FileManager\Resolvers\FileManagerConfigResolver;
use App\Services\FileManager\Resolvers\GoogleCloudConfigResolver;
use App\Services\FileManager\S3SignedUrlService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class FileManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            BucketFactoryInterface::class => BucketFactory::class,
            BucketResolverInterface::class => BucketResolver::class,
            FileManagerConfigResolverInterface::class => FileManagerConfigResolver::class,
            FileRemoverInterface::class => FileRemover::class,
            FileUploaderInterface::class => FileUploader::class,
            GoogleCloudConfigResolverInterface::class => GoogleCloudConfigResolver::class,
            StorageClientFactoryInterface::class => StorageClientFactory::class,
            S3ClientFactoryInterface::class => S3ClientFactory::class,
            S3SignedUrlServiceInterface::class => S3SignedUrlService::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        $this->app->tag(
            [
                LocalStorageUploadManager::class,
                GoogleCloudStorageUploadManager::class,
                S3FileUploadManager::class,
            ],
            FileUploadManagerResolverInterface::class
        );

        $this->app->bind(FileUploadDriverFactoryInterface::class,
            static function (Application $app) {
                return new FileUploadDriverFactory($app->tagged(FileUploadManagerResolverInterface::class));
            }
        );

        $this->app->tag(
            [
                S3FileRemoverManager::class,
            ],
            FileRemoverManagerResolverInterface::class
        );

        $this->app->bind(FileRemoverDriverFactoryInterface::class,
            static function (Application $app) {
                return new FileRemoverDriverFactory($app->tagged(FileRemoverManagerResolverInterface::class));
            }
        );
    }
}
