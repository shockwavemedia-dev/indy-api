<?php

declare(strict_types=1);

namespace App\Jobs\File;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Services\FileManager\Interfaces\BucketResolverInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sentry\Severity;
use Throwable;

/**
 * @deprecated
 */
final class UploadLibraryFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public const INTERNAL_BUCKET = 'CRM-ADMIN';

    private string $filename;

    private ?string $path;

    public function __construct(string $filename, string $path = '')
    {
        $this->filename = $filename;
        $this->path = $path;
    }

    public function handle(
        BucketResolverInterface $bucketResolver,
        FilesystemManager $filesystemManager,
        ErrorLogInterface $sentryHandler
    ): void {
        try {
            // Fetch the temporary file to be uploaded in the client's bucket
            $localFile = $filesystemManager->disk('local')->get(\sprintf('temporary/%s', $this->filename));

            $bucket = $bucketResolver->resolve(self::INTERNAL_BUCKET);

            if ($this->path !== '' && $this->path !== null) {
                $this->path = \sprintf('%s/', $this->path);
            }

            $filepath = \sprintf('%s%s',
                $this->path,
                $this->filename
            );

            $bucket->upload($localFile, [
                'name' => $filepath,
            ]);

            $sentryHandler->log(
                \sprintf('%s has been uploaded', $filepath),
                Severity::info()
            );
        } catch (Throwable $exception) {
            $sentryHandler->reportError($exception);
        }
    }
}
