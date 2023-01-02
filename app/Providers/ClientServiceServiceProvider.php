<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\ClientServices\ClientServiceFactory;
use App\Services\ClientServices\ClientServiceUpdate;
use App\Services\ClientServices\Interfaces\ClientServiceFactoryInterface;
use App\Services\ClientServices\Interfaces\ClientServiceUpdateInterface;
use App\Services\ClientServices\Interfaces\Validations\ClientServicesValidatorInterface;
use App\Services\ClientServices\Interfaces\Validations\ClientServiceValidationRuleInterface;
use App\Services\ClientServices\Validations\ClientServicesValidator;
use App\Services\ClientServices\Validations\Rules\ValidExtrasRuleService;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class ClientServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $services = [
            ClientServiceFactoryInterface::class => ClientServiceFactory::class,
            ClientServiceUpdateInterface::class => ClientServiceUpdate::class,
        ];

        foreach ($services as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        $this->app->tag(
            [
                ValidExtrasRuleService::class,
            ],
            CLientServiceValidationRuleInterface::class
        );

        $this->app->bind(ClientServicesValidatorInterface::class,
            static function (Application $app) {
                return new ClientServicesValidator(
                    $app->make(ServiceRepositoryInterface::class),
                    $app->tagged(ClientServiceValidationRuleInterface::class)
                );
            }
        );
    }
}
