<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\SocialMedia\Factories\SocialMediaAttachmentFactory;
use App\Services\SocialMedia\Factories\SocialMediaCommentFactory;
use App\Services\SocialMedia\Factories\SocialMediaFactory;
use App\Services\SocialMedia\Interfaces\SocialMediaAttachmentFactoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaCalendarMonthResolverInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaCommentFactoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaFactoryInterface;
use App\Services\SocialMedia\Interfaces\SocialMediaUpdateResolverInterface;
use App\Services\SocialMedia\Resolvers\SocialMediaCalendarMonthResolver;
use App\Services\SocialMedia\Resolvers\SocialMediaUpdateResolver;
use Illuminate\Support\ServiceProvider;

final class SocialMediaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            SocialMediaAttachmentFactoryInterface::class => SocialMediaAttachmentFactory::class,
            SocialMediaCalendarMonthResolverInterface::class => SocialMediaCalendarMonthResolver::class,
            SocialMediaCommentFactoryInterface::class => SocialMediaCommentFactory::class,
            SocialMediaFactoryInterface::class => SocialMediaFactory::class,
            SocialMediaUpdateResolverInterface::class => SocialMediaUpdateResolver::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
