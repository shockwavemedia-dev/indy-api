<?php

namespace App\Providers;

use App\Exceptions\ErrorLog;
use App\Helpers\ArrayHelper;
use App\Helpers\Interfaces\ArrayHelperInterface;
use BeyondCode\Mailbox\Facades\Mailbox;
use BeyondCode\Mailbox\InboundEmail;
use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\PasswordBrokerFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TokenRepositoryInterface::class, function ($app) {
            $factory = $app->make(PasswordBrokerFactory::class);

            return $factory->broker()->getRepository();
        });

        Event::listen(MigrationsStarted::class, function () {
            if (env('DB_CONNECTION') === 'mysql' && env('APP_ENV') !== 'local') {
                DB::statement('SET SESSION sql_require_primary_key=0');
            }
        });

        $this->app->bind(ArrayHelperInterface::class, ArrayHelper::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     *
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function boot()
    {
        $sentryHandler = new ErrorLog();
        Mailbox::catchAll(function (InboundEmail $email) use ($sentryHandler) {
            $sentryHandler->log($email->subject());
        });

        Mailbox::from('design@indy.com.au', function (InboundEmail $email) use ($sentryHandler) {
            $sentryHandler->log($email->subject());
        });

        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $total ? $this : $this->forPage($page, $perPage)->values(),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        Schema::defaultStringLength(191);
    }
}
