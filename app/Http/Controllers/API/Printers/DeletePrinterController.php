<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Printers;

use App\Http\Controllers\API\AbstractAPIController;
use App\Models\Printer;
use App\Repositories\Interfaces\PrinterRepositoryInterface;

final class DeletePrinterController extends AbstractAPIController
{
    private PrinterRepositoryInterface $printerRepository;

    public function __construct(PrinterRepositoryInterface $printerRepository)
    {
        $this->printerRepository = $printerRepository;
    }

    public function __invoke(int $id)
    {
        /** @var Printer $printer */
        $printer = $this->printerRepository->find($id);

        if ($printer === null) {
            return $this->respondNoContent();
        }

        $printer->delete();
        $printer->save();

        return $this->respondNoContent();
    }
}
