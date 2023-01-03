<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Printers;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\PrinterJobs\PrinterJobsResource;
use App\Models\Printer;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Repositories\Interfaces\PrinterRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListPrinterJobsByPrinterController extends AbstractAPIController
{
    private PrinterRepositoryInterface $printerRepository;

    private PrinterJobRepositoryInterface $printerJobRepository;

    public function __construct(
        PrinterRepositoryInterface $printerRepository,
        PrinterJobRepositoryInterface $printerJobRepository
    ) {
        $this->printerRepository = $printerRepository;
        $this->printerJobRepository = $printerJobRepository;
    }

    public function __invoke(PaginationRequest $request, int $id): JsonResource
    {
        /** @var Printer $printer */
        $printer = $this->printerRepository->find($id);

        if ($printer === null) {
            return $this->respondNotFound(['message' => 'Printer not found']);
        }

        return new PrinterJobsResource($this->printerJobRepository->findByPrinter(
            $printer,
            $request->getSize(),
            $request->getPageNumber()
        ));
    }
}
