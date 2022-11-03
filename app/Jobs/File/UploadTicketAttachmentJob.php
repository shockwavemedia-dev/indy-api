<?php

declare(strict_types=1);

namespace App\Jobs\File;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Services\FileManager\Interfaces\BucketResolverInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sentry\Severity;
use Throwable;

final class UploadTicketAttachmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $clientId;

    private string $filename;

    private string $filepath;

    public function __construct(int $clientId, string $filename, string $filepath)
    {
        $this->clientId = $clientId;
        $this->filename = $filename;
        $this->filepath = $filepath;
    }

    public function handle(
        BucketResolverInterface $bucketResolver,
        ClientRepositoryInterface $clientRepository,
        FilesystemManager $filesystemManager,
        ErrorLogInterface $sentryHandler
    ): void {
        try {
            $client = $clientRepository->find($this->clientId);

            if ($client === null) {
                return;
            }

            $bucket = $bucketResolver->resolve($client->getClientCode());

            // Fetch the temporary file to be uploaded in the client's bucket
            $localFile = $filesystemManager->disk('local')->get(\sprintf('temporary/%s',$this->filename));

            $filepath = \sprintf('%s/%s',
                $this->filepath,
                $this->filename
            );

            $bucket->upload($localFile, [
                'name' => $filepath,
            ]);

            $sentryHandler->log(
                \sprintf('%s has been uploaded',$filepath),
                Severity::info()
            );

            // Once uploaded in the cloud delete the temporary file
            $filesystemManager->disk('local')->delete(
                \sprintf('temporary/%s',$this->filename)
            );
        } catch (Throwable $exception) {
            $sentryHandler->reportError($exception);        }
    }
}
