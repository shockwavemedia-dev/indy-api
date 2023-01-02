<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Enum\EmailStatusEnum;
use App\Enum\PrinterJobStatusesEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\PrinterJobs\PrinterJobResource;
use App\Models\PrinterJob;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Services\EmailLogs\Interfaces\EmailLogFactoryInterface;
use App\Services\EmailLogs\resources\CreateEmailLogResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AssignPricePrinterJobController extends AbstractAPIController
{
    private EmailLogFactoryInterface $emailLogFactory;

    private PrinterJobRepositoryInterface $printerJobRepository;

    public function __construct(
        EmailLogFactoryInterface $emailLogFactory,
        PrinterJobRepositoryInterface $printerJobRepository,
    ) {
        $this->emailLogFactory = $emailLogFactory;
        $this->printerJobRepository = $printerJobRepository;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke(int $id, Request $request): JsonResource
    {
        /** @var PrinterJob $printerJob */
        $printerJob = $this->printerJobRepository->find($id);

        if ($printerJob === null) {
            return $this->respondNotFound(['message' => 'Printer job not found.']);
        }

        if ($request->get('price') === null) {
            return $this->respondBadRequest([
                'message' => 'Price is required.',
            ]);
        }

        if ($printerJob->getAttribute('status') !== PrinterJobStatusesEnum::FOR_APPROVAL) {
            return $this->respondBadRequest([
                'message' => 'Not allowed anymore to update/put price.',
            ]);
        }

        $printerJob->setAttribute('price', $request->get('price'));
        $printerJob->setAttribute('status', PrinterJobStatusesEnum::FOR_APPROVAL);
        $printerJob->save();

        $message = \sprintf(
            'Hi %s, %s has offered a price for your printer job request #%s.',
            $printerJob->getCreatedBy()->getFirstName(),
            $this->getUser()->getFirstName(),
            $printerJob->getId(),
        );

        $emailLog = $this->emailLogFactory->make(new CreateEmailLogResource([
            'message' => $message,
            'to' => $this->getUser()->getEmail(),
            'status' => new EmailStatusEnum(EmailStatusEnum::PENDING),
            'emailType' => $printerJob,
        ]));

        $printerJob->getCreatedBy()->sendEmailPriceOfferToClient($printerJob, $emailLog);

        return new PrinterJobResource($printerJob);
    }
}
