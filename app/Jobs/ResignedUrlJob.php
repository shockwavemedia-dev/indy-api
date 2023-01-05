<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Slack\Exceptions\SlackUserNullException;
use App\Services\Slack\Interfaces\SlackSendMessageInterface;
use App\Services\Slack\Interfaces\SlackUserResolverInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use function sprintf;
use Throwable;

final class ResignedUrlJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void {
        Artisan::call('files:resigned-url');
    }
}
