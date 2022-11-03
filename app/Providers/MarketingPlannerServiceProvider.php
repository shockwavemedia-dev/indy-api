<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\MarketingPlanners\Factories\MarketingPlannerAttachmentFactory;
use App\Services\MarketingPlanners\Factories\MarketingPlannerFactory;
use App\Services\MarketingPlanners\Factories\MarketingPlannerTaskFactory;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerAttachmentFactoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerAttachmentProcessorInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerFactoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerTaskFactoryInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerTaskUpdateResolverInterface;
use App\Services\MarketingPlanners\Interfaces\MarketingPlannerUpdateResolverInterface;
use App\Services\MarketingPlanners\MarketingPlannerAttachmentProcessor;
use App\Services\MarketingPlanners\Resolvers\MarketingPlannerTaskUpdateResolver;
use App\Services\MarketingPlanners\Resolvers\MarketingPlannerUpdateResolver;
use Illuminate\Support\ServiceProvider;

final class MarketingPlannerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            MarketingPlannerAttachmentFactoryInterface::class => MarketingPlannerAttachmentFactory::class,
            MarketingPlannerAttachmentProcessorInterface::class => MarketingPlannerAttachmentProcessor::class,
            MarketingPlannerFactoryInterface::class => MarketingPlannerFactory::class,
            MarketingPlannerUpdateResolverInterface::class => MarketingPlannerUpdateResolver::class,
            MarketingPlannerTaskFactoryInterface::class => MarketingPlannerTaskFactory::class,
            MarketingPlannerTaskUpdateResolverInterface::class => MarketingPlannerTaskUpdateResolver::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
