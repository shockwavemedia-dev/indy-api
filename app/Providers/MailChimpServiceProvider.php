<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\MailChimp\Factories\MailChimpClientFactory;
use App\Services\MailChimp\Interfaces\CampaignListResolverInterface;
use App\Services\MailChimp\Interfaces\ListResolverInterface;
use App\Services\MailChimp\Interfaces\MailChimpClientFactoryInterface;
use App\Services\MailChimp\Resolvers\CampaignListResolver;
use App\Services\MailChimp\Resolvers\ListResolver;
use Illuminate\Support\ServiceProvider;

final class MailChimpServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            CampaignListResolverInterface::class => CampaignListResolver::class,
            ListResolverInterface::class => ListResolver::class,
            MailChimpClientFactoryInterface::class => MailChimpClientFactory::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
