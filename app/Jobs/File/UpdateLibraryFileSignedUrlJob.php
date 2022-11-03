<?php

declare(strict_types=1);

namespace App\Jobs\File;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Models\File;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\Libraries\Interfaces\LibraryFileFetcherInterface;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sentry\Severity;
use Throwable;

/**
 * @deprecated
 */
class UpdateLibraryFileSignedUrlJob implements ShouldQueue
{
    /**
     * @var int
     */
    private const MINUTES_EXPIRY = 1051920;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $fileId;

    private ?int $expiryMinutes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $fileId, ?int $expiryMinutes = null)
    {
        $this->expiryMinutes = $expiryMinutes ?? self::MINUTES_EXPIRY;
        $this->fileId = $fileId;
    }

    public function handle(
        FileRepositoryInterface $fileRepository,
        LibraryFileFetcherInterface $fileFetcher,
        ErrorLogInterface $sentryHandler
    ): void {
        try {
            $file = $fileRepository->find($this->fileId);

            if($file === null) {
                return;
            }

            $signedUrl = $fileFetcher->signedUrl(
                $file,
                $this->expiryMinutes
            );

            $dateToday = new Carbon();

            $fileRepository->updateSignedUrl(
                $file,
                $signedUrl,
                $dateToday->addMinutes($this->expiryMinutes)
            );

            $sentryHandler->log(
                \sprintf(
                    'File %s url has been set, with path %s',
                    $file->getFileName(),
                    $file->getFilePath()
                ),
                Severity::info()
            );
        } catch (Throwable $exception) {
            $sentryHandler->reportError($exception);
        }
    }
}
