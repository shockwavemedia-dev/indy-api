<?php

namespace App\Console;

use App\Console\Commands\ResetExtraQuoteToZero;
use App\Console\Commands\UpdateExpiredFileUrl;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Config;

final class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('passport:purge')->hourly();

        $schedule->command(UpdateExpiredFileUrl::class)->daily();

        $schedule->command(ResetExtraQuoteToZero::class)->lastDayOfMonth('15:00');

        if (Config::get('app.demo_server') === true) {
            $schedule->exec('php artisan db:seed', [
                '--force' => true,
            ])->dailyAt('3:00')->timezone('Australia/Sydney');

            $schedule->exec('php artisan files:resigned-url')
                ->dailyAt('3:00')->timezone('Australia/Sydney');
        }
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
