<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Enum\EmailStatusEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\PrinterJobs\PrinterJobResource;
use App\Models\PrinterJob;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use Illuminate\Http\Request;

final class ChangeStatusPrinterJobController extends AbstractAPIController
{
    private EmailLogFactoryInterface $emailLogFactory;

    private PrinterJobRepositoryInterface $printerJobRepository;

    public function __construct(
        EmailLogFactoryInterface $emailLogFactory,
        PrinterJobRepositoryInterface $printerJobRepository
    ) {
        $this->emailLogFactory = $emailLogFactory;
        $this->printerJobRepository = $printerJobRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(Request $request, int $id)
    {
        /** @var PrinterJob $printerJob */
        $printerJob = $this->printerJobRepository->find($id);

        $status = $request->get('status') ?? null;

        if ($status === null) {
            return $this->respondBadRequest([
                'message' => 'Status field is required.',
            ]);
        }

        $printerJob->setAttribute('status', $status);
        $printerJob->setAttribute('updated_by', $this->getUser()->getId());
        $printerJob->save();

        $message = \sprintf(
            'Hi %s, %s has updated the status printer job request #%s to %s.',
            $printerJob->getCreatedBy()->getFirstName(),
            $this->getUser()->getFirstName(),
            $printerJob->getId(),
            $printerJob->getAttribute('status'),
        );

        $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
            'message' => $message,
            'to' => $this->getUser()->getEmail(),
            'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
            'emailType' => $printerJob,
        ]));

        $printerJob->getCreatedBy()->sendEmailPrinterJobUpdateStatusToClient($printerJob, $emailLog);

        return new PrinterJobResource($printerJob);
    }
}
