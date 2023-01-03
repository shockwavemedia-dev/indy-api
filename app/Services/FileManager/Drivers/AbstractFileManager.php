<?php

declare(strict_types=1);

namespace App\Services\FileManager\Drivers;

use App\Exceptions\Interfaces\ErrorLogInterface;
use App\Repositories\Interfaces\FileRepositoryInterface;

abstract class AbstractFileManager
{
    /**
     * @var int
     */
    protected const MINUTES_EXPIRY = 525960;

    protected FileRepositoryInterface $fileRepository;

    protected ErrorLogInterface $sentryHandler;

    public function __construct(
        FileRepositoryInterface $fileRepository,
        ErrorLogInterface $sentryHandler
    ) {
        $this->fileRepository = $fileRepository;
        $this->sentryHandler = $sentryHandler;
    }
}
