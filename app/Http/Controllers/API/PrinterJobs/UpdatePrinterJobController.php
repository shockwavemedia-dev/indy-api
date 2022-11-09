<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PrinterJobs;

use App\Enum\UserTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PrinterJobs\CreatePrinterJobRequest;
use App\Http\Resources\API\PrinterJobs\PrinterJobResource;
use App\Jobs\PrinterJobs\GenericPrintManagerSlackNotificationJob;
use App\Models\PrinterJob;
use App\Repositories\Interfaces\PrinterJobRepositoryInterface;
use App\Services\PrinterJobs\Interfaces\UpdatePrinterJobResolverInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdatePrinterJobController extends AbstractAPIController
{
    private PrinterJobRepositoryInterface $printerJobRepository;

    private UpdatePrinterJobResolverInterface $updatePrinterJobResolver;

    public function __construct(
        PrinterJobRepositoryInterface $printerJobRepository,
        UpdatePrinterJobResolverInterface $updatePrinterJobResolver
    ) {
        $this->printerJobRepository = $printerJobRepository;
        $this->updatePrinterJobResolver = $updatePrinterJobResolver;
    }

    public function __invoke(int $id, CreatePrinterJobRequest $request): JsonResource
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


        $changes = $request->only([
            'customer_name',
            'product',
            'option',
            'kinds',
            'quantity',
            'run_ons',
            'format',
            'final_trim_size',
            'reference',
            'notes',
            'additional_options',
            'delivery',
            'price',
            'blind_shipping',
            'reseller_samples',
            'stocks',
            'coding',
            'address',
            'purchase_order_number'
        ]);



        $changes['reseller_samples'] = filter_var($changes['reseller_samples'] ?? null, FILTER_VALIDATE_BOOLEAN);

        $changes['blind_shipping'] = filter_var($changes['blind_shipping'] ?? null, FILTER_VALIDATE_BOOLEAN);

        $changes = [
            ...$changes,
            ...[
                'updated_by' => $this->getUser()->getId(),
            ],
        ];

        $printerJob = $this->updatePrinterJobResolver->resolve($printerJob, $changes);

        $message = \sprintf('Hi %s, %s has updated the printer job request.',
            $this->getUser()->getFirstName(),
            $printerJob->getPrinter()->getUser()->getFirstName(),
        );

        GenericPrintManagerSlackNotificationJob::dispatch($printerJob->getId(), $message);

        return new PrinterJobResource($printerJob);
    }
}
