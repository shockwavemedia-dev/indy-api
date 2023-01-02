<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

final class MySqlDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:dump {driver : DB Driver}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the mysqldump utility using info from .env';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ds = DIRECTORY_SEPARATOR;

        $driver = $this->argument('driver');

        $keyConfig = sprintf('database.connections.%s', $driver);

        $config = Config::get($keyConfig);

        $host = Arr::get($config, 'host');
        $username = Arr::get($config, 'username');
        $password = Arr::get($config, 'password');
        $database = Arr::get($config, 'database');

        $ts = time();

        $path = database_path().$ds.'backups'.$ds.date('Y', $ts).$ds.date('m', $ts).$ds.date('d', $ts).$ds;
        $file = date('Y-m-d-His', $ts).'-dump-'.$database.'.sql';
        $command = sprintf('pg_dump -h %s -U %s -W\'%s\' %s > %s', $host, $username, $password, $database, $path.$file);

        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        exec($command);
    }
}
