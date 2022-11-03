<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\PrinterJob;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeletePrinterJobController extends AbstractAPIController
{
    private PrinterJobRepositoryInterface $printerJobRepository;

    public function __construct(PrinterJobRepositoryInterface $printerJobRepository) {
        $this->printerJobRepository = $printerJobRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var PrinterJob $printerJob */
        $printerJob = $this->printerJobRepository->find($id);

        if ($printerJob === null) {
            return $this->respondNoContent();
        }

        $this->printerJobRepository->deletePrinterJob($printerJob);

        return $this->respondNoContent();
    }
}
