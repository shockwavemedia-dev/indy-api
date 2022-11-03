<?php

namespace App\Services\ErrorLogs;

use App\Models\ErrorLog;
use App\Repositories\Interfaces\ErrorLogRepositoryInterface;
use App\Services\ErrorLogs\Interfaces\ErrorLogFactoryInterface;
use App\Services\ErrorLogs\Resources\CreateErrorLogResource;

final class ErrorLogFactory implements ErrorLogFactoryInterface
{
    private ErrorLogRepositoryInterface $errorLogRepository;

    public function __construct(ErrorLogRepositoryInterface $errorLogRepository)
    {
        $this->errorLogRepository = $errorLogRepository;
    }

    public function make(CreateErrorLogResource $resource): ErrorLog
    {
        /** @var ErrorLog $errorLog */
        $errorLog = $this->errorLogRepository->create([
            'context' => $resource->getContext(),
            'level' => $resource->getLevel(),
            'message' => $resource->getMessage(),
        ]);

        return $errorLog;
    }
}
