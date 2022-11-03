<?php

declare(strict_types=1);

namespace App\Jobs\ErrorLogs;

use App\Services\ErrorLogs\Interfaces\ErrorLogFactoryInterface;
use App\Services\ErrorLogs\Resources\CreateErrorLogResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ErrorLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $context;

    private string $level;

    private string $message;

    public function __construct(
        string $context,
        string $level,
        string $message
    ) {
        $this->context = $context;
        $this->level = $level;
        $this->message = $message;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function handle(
        ErrorLogFactoryInterface $errorLogFactory
    ): void {
        $errorLogFactory->make( new CreateErrorLogResource([
                'context' => $this->context,
                'level' => $this->message,
                'message' => $this->level,
            ])
        );
    }
}
