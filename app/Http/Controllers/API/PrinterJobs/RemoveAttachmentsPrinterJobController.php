<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PrinterJobs\RemoveAttachmentsPrinterJobRequest;
use App\Http\Resources\API\PrinterJobs\PrinterJobResource;
use App\Jobs\File\RemoveFileJob;
use App\Models\PrinterJob;
use App\Models\PrinterJobAttachment;
use App\Repositories\Interfaces\PrinterJobAttachmentRepositoryInterface;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Event;
use OwenIt\Auditing\Events\AuditCustom;

final class RemoveAttachmentsPrinterJobController extends AbstractAPIController
{
    private PrinterJobAttachmentRepositoryInterface $printerJobAttachmentRepository;

    private PrinterJobRepositoryInterface $printerJobRepository;

    public function __construct(
        PrinterJobAttachmentRepositoryInterface $printerJobAttachmentRepository,
        PrinterJobRepositoryInterface $printerJobRepository,
    ) {
        $this->printerJobAttachmentRepository = $printerJobAttachmentRepository;
        $this->printerJobRepository = $printerJobRepository;
    }

    public function __invoke(RemoveAttachmentsPrinterJobRequest $request, int $id): JsonResource
    {
        /** @var PrinterJob $printerJob */
        $printerJob = $this->printerJobRepository->find($id);

        if ($printerJob === null) {
            return $this->respondNotFound([
                'message' => 'Printer Job not found',
            ]);
        }

        if ($request->getAttachmentIds() === null) {
            return new PrinterJobResource($printerJob);
        }
        $attachments = $this->printerJobAttachmentRepository->findByIds($request->getAttachmentIds());

        /** @var PrinterJobAttachment $attachments */
        foreach ($attachments as $attachment) {
            $printerJob->auditEvent = 'deleted';
            $printerJob->isCustomEvent = true;
            $printerJob->auditCustomOld = [
                'attachment' => $attachment->getFile()->getOriginalFilename(),
            ];
            $printerJob->auditCustomNew = [
                'attachment' => '',
            ];

            Event::dispatch(AuditCustom::class, [$printerJob]);

            RemoveFileJob::dispatch(
                $attachment->getFile()->getId(),
                $this->getUser()->getId()
            );

            $attachment->delete();
        }

        return new PrinterJobResource($printerJob);
    }
}
