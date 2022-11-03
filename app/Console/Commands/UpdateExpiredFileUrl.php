<?php

namespace App\Console\Commands;

use App\Services\Files\Interfaces\ExpiredFilesUrlResolverInterface;
use Illuminate\Console\Command;

class UpdateExpiredFileUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:resigned-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update signed url';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ExpiredFilesUrlResolverInterface $expiredFilesUrlResolver)
    {
        $expiredFilesUrlResolver->resolve();

        $this->info('The command was successful!');

        return 0;
    }
}
