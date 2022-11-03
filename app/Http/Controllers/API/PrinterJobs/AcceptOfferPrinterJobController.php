<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Enum\PrinterJobStatusesEnum;
use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\PrinterJobs\PrinterJobResource;
use App\Jobs\PrinterJobs\GenericPrintManagerSlackNotificationJob;
use App\Models\PrinterJob;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Services\PrinterJobs\Interfaces\UpdatePrinterJobResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class AcceptOfferPrinterJobController extends AbstractAPIController
{
    private PrinterJobRepositoryInterface $printerJobRepository;

    private UpdatePrinterJobResolverInterface $updatePrinterJobResolver;

    public function __construct(
        PrinterJobRepositoryInterface $printerJobRepository
    ) {
        $this->printerJobRepository = $printerJobRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        /** @var PrinterJob $printerJob */
        $printerJob = $this->printerJobRepository->find($id);

        if ($printerJob === null) {
            return $this->respondNotFound(['message' => 'Printer job not found.']);
        }

        if (
            $this->getUser()->getUserType()->getType()->getValue() !== UserTypeEnum::ADMIN &&
            $printerJob->client->getId() !== $this->getUser()->getUserType()->getClient()->getId()
        ) {
            return $this->respondForbidden();
        }

        $printerJob->setAttribute('is_approved', 1);
        $printerJob->setAttribute('status', PrinterJobStatusesEnum::IN_PROGRESS);
        $printerJob->save();

        $message = \sprintf('Hi %s, %s has accepted your price you can now proceed on the request.',
            $printerJob->getCreatedBy()->getFirstName(),
            $printerJob->getPrinter()->getUser()->getFirstName(),
        );

        GenericPrintManagerSlackNotificationJob::dispatch($printerJob->getId(), $message);

        return new PrinterJobResource($printerJob);
    }
}
