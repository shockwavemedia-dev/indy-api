<?php

namespace App\Providers;

use App\Services\SMS\Interfaces\SmsClientInterface;
use App\Services\SMS\Interfaces\SmsConfigResolverInterface;
use App\Services\SMS\Interfaces\SmsServiceInterface;
use App\Services\SMS\Resolvers\SmsConfigResolver;
use App\Services\SMS\SmsClient;
use App\Services\SMS\SmsService;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            ClientInterface::class => Client::class,
            SmsConfigResolverInterface::class => SmsConfigResolver::class,
            SmsClientInterface::class => SmsClient::class,
            SmsServiceInterface::class => SmsService::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
