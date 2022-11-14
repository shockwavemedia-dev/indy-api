<?php

namespace App\Console;

use App\Console\Commands\ResetExtraQuoteToZero;
use App\Console\Commands\UpdateExpiredFileUrl;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('passport:purge')->hourly();

        $schedule->command(UpdateExpiredFileUrl::class)->weekends();

        $schedule->command(ResetExtraQuoteToZero::class)->lastDayOfMonth('15:00');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
