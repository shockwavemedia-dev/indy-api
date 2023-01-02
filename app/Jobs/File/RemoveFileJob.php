<?php

declare(strict_types=1);

namespace App\Jobs\File;

use App\Repositories\Interfaces\FileRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\FileManager\Interfaces\FileRemoverInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class RemoveFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $fileId;

    private int $userId;

    public function __construct(int $fileId, int $userId)
    {
        $this->fileId = $fileId;
        $this->userId = $userId;
    }

    public function handle(
        FileRepositoryInterface $fileRepository,
        FileRemoverInterface $fileRemover,
        UserRepositoryInterface $userRepository,
    ): void {
        $file = $fileRepository->find($this->fileId);
        $user = $userRepository->find($this->userId);

        if ($file === null || $user === null) {
            return;
        }

        $fileRemover->delete($file, $user);
    }
}
