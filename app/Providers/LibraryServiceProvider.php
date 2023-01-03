<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Libraries\Factories\LibraryFactory;
use App\Services\Libraries\Factories\LibraryTicketEventFactory;
use App\Services\Libraries\Interfaces\Factories\LibraryFactoryInterface;
use App\Services\Libraries\Interfaces\Factories\LibraryTicketEventFactoryInterface;
use App\Services\Libraries\Interfaces\LibraryFileFetcherInterface;
use App\Services\Libraries\Interfaces\LibraryFileRemoverInterface;
use App\Services\Libraries\Interfaces\LibraryFileUploaderInterface;
use App\Services\Libraries\LibraryFileFetcher;
use App\Services\Libraries\LibraryFileRemover;
use App\Services\Libraries\LibraryFileUploader;
use Illuminate\Support\ServiceProvider;

final class LibraryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            LibraryFactoryInterface::class => LibraryFactory::class,
            LibraryFileFetcherInterface::class => LibraryFileFetcher::class,
            LibraryFileRemoverInterface::class => LibraryFileRemover::class,
            LibraryFileUploaderInterface::class => LibraryFileUploader::class,
            LibraryTicketEventFactoryInterface::class => LibraryTicketEventFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
