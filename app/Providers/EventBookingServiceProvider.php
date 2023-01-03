<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\EventsService\Factories\EventFactory;
use App\Services\EventsService\Factories\EventFolderFactory;
use App\Services\EventsService\Interfaces\CalendarStaffResolverInterface;
use App\Services\EventsService\Interfaces\EventFactoryInterface;
use App\Services\EventsService\Interfaces\EventFileFolderUpdateResolverInterface;
use App\Services\EventsService\Interfaces\EventFolderFactoryInterface;
use App\Services\EventsService\Interfaces\EventUpdateResolverInterface;
use App\Services\EventsService\Interfaces\FilesUploadResolverInterface;
use App\Services\EventsService\Resolvers\CalendarStaffResolver;
use App\Services\EventsService\Resolvers\EventFileFolderUpdateResolver;
use App\Services\EventsService\Resolvers\EventUpdateResolver;
use App\Services\EventsService\Resolvers\FilesUploadResolver;
use Illuminate\Support\ServiceProvider;

final class EventBookingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            CalendarStaffResolverInterface::class => CalendarStaffResolver::class,
            EventFactoryInterface::class => EventFactory::class,
            EventFolderFactoryInterface::class => EventFolderFactory::class,
            EventFileFolderUpdateResolverInterface::class => EventFileFolderUpdateResolver::class,
            EventUpdateResolverInterface::class => EventUpdateResolver::class,
            FilesUploadResolverInterface::class => FilesUploadResolver::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
