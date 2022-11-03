<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\PrinterJobs\PrinterJobResource;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Repositories\Interfaces\PrinterRepositoryInterface;
use Illuminate\Http\Request;

final class AssignPrinterJobController extends AbstractAPIController
{
    private PrinterJobRepositoryInterface $printerJobRepository;

    private PrinterRepositoryInterface $printerRepository;

    public function __construct(
        PrinterJobRepositoryInterface $printerJobRepository,
        PrinterRepositoryInterface $printerRepository
    ) {
        $this->printerRepository = $printerRepository;
        $this->$printerJobRepository = $printerJobRepository;
    }

    public function __invoke(Request $request, int $id)
    {
        $printerJob = $this->printerJobRepository->find($id);

        $printerId = $request->get('printer_id') ?? null;

        if ($printerId === null) {
            return $this->respondBadRequest([
                'message' => 'Printer field is required.',
            ]);
        }

        $printer = $this->printerRepository->find($printerId);

        if ($printer === null) {
            return $this->respondBadRequest([
                'message' => 'Printer provided is invalid',
            ]);
        }

        $printerJob->setAttribute('printer_id', $printer->getAttribute('id'));
        $printerJob->setAttribute('updated_by', $this->getUser()->getId());
        $printerJob->save();

        return new PrinterJobResource($printerJob);
    }

}
