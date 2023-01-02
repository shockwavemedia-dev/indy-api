<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\API\PrinterJobs\PrinterJobResource;
use App\Jobs\PrinterJobs\GenericPrintManagerSlackNotificationJob;
use App\Models\PrinterJob;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Services\PrinterJobs\Interfaces\UpdatePrinterJobResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class DeclinedOfferPrinterJobController extends AbstractAPIController
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

        $printerJob->setAttribute('is_approved', 0);
        $printerJob->save();

        $message = \sprintf('Hi %s, %s has declined your price.',
            $printerJob->getCreatedBy()->getFirstName(),
            $printerJob->getPrinter()->getUser()->getFirstName(),
        );

        GenericPrintManagerSlackNotificationJob::dispatch($printerJob->getId(), $message);

        return new PrinterJobResource($printerJob);
    }
}
