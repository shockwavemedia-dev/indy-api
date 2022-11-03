<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\PrinterJobs\PrinterJobResource;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowPrinterJobController extends AbstractAPIController
{
    private PrinterJobRepositoryInterface $printerJobRepository;

    public function __construct(PrinterJobRepositoryInterface $printerJobRepository) {
        $this->printerJobRepository = $printerJobRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        $printerJob = $this->printerJobRepository->find($id);

        if ($printerJob === null) {
            return $this->respondNotFound(['message' => 'Printer job not found.']);
        }

        return new PrinterJobResource($printerJob);
    }
}
