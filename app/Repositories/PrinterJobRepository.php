<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Client;
use App\Models\Printer;
use App\Models\PrinterJob;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class PrinterJobRepository extends BaseRepository implements PrinterJobRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new PrinterJob());
    }

    public function findByClient(
        Client $client,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        return $this->model->where('client_id', '=', $client->getId())
            ->orderBy('id', 'desc')
            ->paginate($size, ['*'], null, $pageNumber);
    }

    public function deletePrinterJob(PrinterJob $printerJob): void
    {
        $printerJob->delete();
        $printerJob->save();
    }

    public function findByPrinter(
        Printer $printer,
        ?int $size = null,
        ?int $pageNumber = null
    ): LengthAwarePaginator {
        return $this->model->where('printer_id', '=', $printer->getId())
            ->paginate($size, ['*'], null, $pageNumber);
    }
}
