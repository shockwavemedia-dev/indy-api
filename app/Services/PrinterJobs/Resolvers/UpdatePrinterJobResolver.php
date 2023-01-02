<?php

declare(strict_types=1);

namespace App\Services\PrinterJobs\Resolvers;

use App\Models\PrinterJob;
use App\Services\PrinterJobs\Interfaces\UpdatePrinterJobResolverInterface;

final class UpdatePrinterJobResolver implements UpdatePrinterJobResolverInterface
{
    public function resolve(PrinterJob $printerJob, array $changes): PrinterJob
    {
        $printerJob->update($changes);

        $printerJob->refresh();

        return $printerJob;
    }
}
