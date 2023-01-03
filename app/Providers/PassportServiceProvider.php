<?php

declare(strict_types=1);

namespace App\Providers;

use Laravel\Passport\PassportServiceProvider as BasePassportServiceProvider;

class PassportServiceProvider extends BasePassportServiceProvider
{
    /**
     * Workaround to fix the closure not being executed ever
     *
     * @return void
     */
    protected function registerGuard()
    {
        $this->app['auth']->extend('passport', function ($app, $name, array $config) {
            return tap($this->makeGuard($config), function ($guard) {
                $this->app->refresh('request', $guard, 'setRequest');
            });
        });
    }
}
