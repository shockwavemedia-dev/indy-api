<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\ClientTicketFiles\Interfaces\ProcessTicketFileReplaceInterface;
use App\Services\ClientTicketFiles\Interfaces\ProcessTicketFileUploadInterface;
use App\Services\ClientTicketFiles\Interfaces\TicketFileFactoryInterface;
use App\Services\ClientTicketFiles\ProcessTicketFileReplace;
use App\Services\ClientTicketFiles\ProcessTicketFileUpload;
use App\Services\ClientTicketFiles\TicketFileFactory;
use App\Services\Files\ExpiredFilesUrlResolver;
use App\Services\Files\FileFactory;
use App\Services\Files\Interfaces\ExpiredFilesUrlResolverInterface;
use App\Services\Files\Interfaces\FileFactoryInterface;
use Illuminate\Support\ServiceProvider;

final class FileServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            ExpiredFilesUrlResolverInterface::class => ExpiredFilesUrlResolver::class,
            FileFactoryInterface::class => FileFactory::class,
            ProcessTicketFileUploadInterface::class => ProcessTicketFileUpload::class,
            ProcessTicketFileReplaceInterface::class => ProcessTicketFileReplace::class,
            TicketFileFactoryInterface::class => TicketFileFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
