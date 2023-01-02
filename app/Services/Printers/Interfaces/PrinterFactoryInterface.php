<?php

namespace App\Services\Printers\Interfaces;

use App\Models\Printer;
use App\Services\Printers\Resources\CreatePrinterResource;

interface PrinterFactoryInterface
{
    public function make(CreatePrinterResource $resource): Printer;
}
