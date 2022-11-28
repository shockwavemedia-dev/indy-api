<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\TicketAssignee\DesignatorResolverFactory;
use App\Services\TicketAssignee\Interfaces\DesignatorResolverFactoryInterface;
use App\Services\TicketAssignee\Interfaces\DesignatorResolverInterface;
use App\Services\TicketAssignee\Resolvers\AnimatorDesignatorResolver;
use App\Services\TicketAssignee\Resolvers\DesignerDesignatorResolver;
use App\Services\TicketAssignee\Resolvers\PrinterManagerDesignatorResolver;
use App\Services\TicketAssignee\Resolvers\SocialMediaManagerDesignatorResolver;
use App\Services\TicketAssignee\Resolvers\WebEditorDesignatorResolver;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class TicketAssigneeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->tag(
            [
                AnimatorDesignatorResolver::class,
                DesignerDesignatorResolver::class,
                PrinterManagerDesignatorResolver::class,
                SocialMediaManagerDesignatorResolver::class,
                WebEditorDesignatorResolver::class,
            ],
            DesignatorResolverInterface::class
        );

        $this->app->bind(DesignatorResolverFactoryInterface::class,
            static function (Application $app) {
                return new DesignatorResolverFactory(
                    $app->tagged(DesignatorResolverInterface::class)
                );
            }
        );

        $services = [];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
