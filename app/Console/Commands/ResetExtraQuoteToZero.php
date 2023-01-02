<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetExtraQuoteToZero extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:extra-quota';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset extra quota to 0';

    public function handle(): int
    {
        $this->info('The command will reset extra quota to 0');

        DB::table('client_services')->update([
            'extra_quota' => 0,
        ]);

        return 0;
    }
}
