<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Printers;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\Printers\PrinterResource;
use App\Repositories\Interfaces\PrinterRepositoryInterface;
use Illuminate\Http\JsonResponse;

final class ShowPrinterController extends AbstractAPIController
{
    private PrinterRepositoryInterface $printerRepository;

    public function __construct(PrinterRepositoryInterface $printerRepository)
    {
        $this->printerRepository = $printerRepository;
    }

    public function __invoke(int $id)
    {
        $printer = $this->printerRepository->find($id);

        if ($printer === null) {
            return $this->respondNotFound();
        }

        return new PrinterResource($printer);
    }
}
