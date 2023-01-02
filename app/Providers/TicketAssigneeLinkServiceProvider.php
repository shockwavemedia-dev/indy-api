<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\TicketAssigneeLinks\Interfaces\TicketAssigneeLinkFactoryInterface;
use App\Services\TicketAssigneeLinks\Interfaces\TicketAssigneeLinkResolverInterface;
use App\Services\TicketAssigneeLinks\TicketAssigneeLinkFactory;
use App\Services\TicketAssigneeLinks\TicketAssigneeLinkResolver;
use Illuminate\Support\ServiceProvider;

final class TicketAssigneeLinkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            TicketAssigneeLinkResolverInterface::class => TicketAssigneeLinkResolver::class,
            TicketAssigneeLinkFactoryInterface::class => TicketAssigneeLinkFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
