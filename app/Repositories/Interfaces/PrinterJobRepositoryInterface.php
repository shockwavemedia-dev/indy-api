<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use App\Models\Printer;
use App\Models\PrinterJob;
use Illuminate\Pagination\LengthAwarePaginator;

interface PrinterJobRepositoryInterface
{
    public function findByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator;

    public function findByPrinter(
        Printer $printer,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator;

    public function deletePrinterJob(PrinterJob $printerJob): void;
}
