<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\PrinterJob;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasPrinterJobRelationship
{
    public function getPrinterJob(): PrinterJob
    {
        return $this->printerJob;
    }

    public function printerJob(): BelongsTo
    {
        return $this->belongsTo(PrinterJob::class);
    }
}
