<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\TicketChats\Factories\TicketChatFactory;
use App\Services\TicketChats\Interfaces\TicketChatFactoryInterface;
use Illuminate\Support\ServiceProvider;

final class TicketChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            TicketChatFactoryInterface::class => TicketChatFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
