<?php

declare(strict_types=1);

namespace App\Jobs\File;

use App\Enum\ClientNotificationTypeEnum;
use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Services\ClientUserNotifications\Interfaces\ClientNotificationResolverFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploadDriverFactoryInterface;
use App\Services\FileManager\Interfaces\FileManagerConfigResolverInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

final class UploadFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ?string $rawFile = null;

    private int $fileId;

    public function __construct(int $fileId, ?string $rawFile = null)
    {
        $this->fileId = $fileId;
        $this->rawFile = $rawFile;
    }

    public function handle(
        ClientNotificationResolverFactoryInterface $clientNotificationResolverFactory,
        FileUploadDriverFactoryInterface           $fileDriverFactory,
        FileManagerConfigResolverInterface         $fileManagerConfigResolver,
        FileRepositoryInterface                    $fileRepository,
        ErrorLogInterface                          $sentryHandler
    ): void {
        try {
            $file = $fileRepository->find($this->fileId);

            if ($file === null) {
                return;
            }

            $config = $fileManagerConfigResolver->resolve();

            $fileManager = $fileDriverFactory->make($config['driver']);

            $fileManager->upload($file, $this->rawFile);

            if ($file->getClientTicketFile() === null) {
                return;
            }

            $clientNotificationResolver = $clientNotificationResolverFactory->make(
                new ClientNotificationTypeEnum(ClientNotificationTypeEnum::TICKET_FILE_UPLOADED)
            );

            $clientNotificationResolver->resolve($file->getClientTicketFile());
        } catch (Throwable $exception) {
            $sentryHandler->reportError($exception);
        }
    }
}
