<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Printers;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PaginationRequest;
use App\Http\Resources\API\Printers\PrintersResource;
use App\Repositories\Interfaces\PrinterRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListPrinterController extends AbstractAPIController
{
    private PrinterRepositoryInterface $printerRepository;

    public function __construct(PrinterRepositoryInterface $printerRepository)
    {
        $this->printerRepository = $printerRepository;
    }

    public function __invoke(PaginationRequest $request): JsonResource
    {
        $printer = $this->printerRepository->findAll(
            $request->getSize(),
            $request->getPageNumber()
        );

        return new PrintersResource($printer);
    }
}
